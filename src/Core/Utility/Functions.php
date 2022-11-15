<?php

namespace RakutenSDK\Core\Utility;

use Cake\I18n\FrozenTime;
use RakutenSDK\Core\Domain\FileWrapper;
use DateTimeInterface;
use DateTimeZone;
use GuzzleHttp\Utils;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use SimpleXMLElement;
use SplFileObject;
use SplTempFileObject;

class Functions
{
    /**
     * @param array $a1
     * @param array $a2
     * @return  array
     */
    public static function arrayDiffKeyRecursive(array $a1, array $a2): array
    {
        $diff = array_diff_key($a1, $a2);
        foreach (array_intersect_key($a1, $a2) as $k => $v) {
            if (is_array($a1[$k]) && is_array($a2[$k])) {
                $d = self::arrayDiffKeyRecursive($a1[$k], $a2[$k]);
                if ($d) {
                    $diff[$k] = $d;
                }
            }
        }
        return $diff;
    }

    /**
     * Checks if given array is an associative or a sequential array
     *
     * @param   $array
     * @return  bool
     */
    public static function arrayIsAssoc($array): bool
    {
        // Keys of the array
        $keys = array_keys($array);

        // If the array keys of the keys match the keys, then the array must
        // not be associative (e.g. the keys array looked like {0:0, 1:1...}).
        return array_keys($keys) !== $keys;
    }

    /**
     * Maps original array keys against given mapping
     *
     * @param array $data
     * @param array $mapping
     * @return  array
     */
    public static function arrayMapKeys(array $data, array $mapping): array
    {
        if (empty($mapping)) {
            return $data;
        }

        $values = $map = [];
        foreach ($mapping as $src => $dest) {
            // Handle sources
            $value = $data;
            $keys = explode('/', $src);
            foreach ($keys as $key) {
                if (!isset($value[$key])) {
                    continue 2;
                }
                $value = $value[$key];
            }

            // Handle destinations
            $keys = explode('/', $dest);
            foreach (array_reverse($keys) as $key) {
                $value = [$key => $value];
            }
            $values = array_merge_recursive($values, (array)$value);
            unset($data[$src]);

            // Build a map to make a diff later
            $value = $dest;
            $keys = explode('/', $src);
            if (count($keys) > 1 || $keys[0] != $value) {
                foreach (array_reverse($keys) as $key) {
                    $value = [$key => $value];
                }
                $map = array_merge_recursive($map, (array)$value);
            }
        }

        $data = array_merge_recursive($data, $values);

        return self::arrayDiffKeyRecursive($data, $map);
    }

    /**
     * Formats string values to corresponding types (bool, int, float)
     *
     * @param array $array
     * @return  array
     */
    public static function arrayFormat(array $array): array
    {
        foreach ($array as $key => $value) {
            if ($value === 'true' || $value === 'false') {
                $array[$key] = $value === 'true';
            } elseif (is_string($value) && is_numeric($value) && ('0' !== $value[0] || !ctype_digit($value))) {
                $array[$key] = $value + 0; // Converts string to numeric value (int or float)
            }
        }

        return $array;
    }

    /**
     * Creates a file from different sources
     *
     * @param string|array|\SimpleXMLElement|\SplFileObject $file
     * @return  \SplFileObject
     */
    public static function createFile(string|array|SimpleXMLElement|SplFileObject $file): SplFileObject
    {
        if (is_string($file)) {
            // File has been specified as file contents
            $file = self::createTempFile($file);
        }elseif ($file instanceof SimpleXMLElement) {
                // File has been specified as file contents
                $file = self::createTempFile($file->asXML());
        } elseif (is_array($file)) {
            // File has been specified as CSV data array
            $file = self::createTempCsvFile($file);
        } elseif (!$file instanceof SplFileObject) {
            // Otherwise, file has to be specified as \SplFileObject
            throw new InvalidArgumentException('Specified file is not valid');
        }
        return $file;
    }

    /**
     * Creates a temporary file filled with specified contents
     *
     * @param string $contents
     * @return  \SplTempFileObject
     */
    public static function createTempFile(string $contents): SplTempFileObject
    {
        $file = new SplTempFileObject();
        $file->fwrite($contents);
        $file->rewind();

        return $file;
    }

    /**
     * Creates a temp CSV file from specified array.
     * Columns have to be specified manually as first element if needed.
     *
     * @param array $data
     * @param string $separator
     * @param string $enclosure
     * @param string $escape
     * @return  \SplTempFileObject
     */
    public static function createTempCsvFile(array $data, string $separator = ';', string $enclosure = '"', string $escape = '\\'): SplTempFileObject
    {
        $file = new SplTempFileObject();
        $file->setFlags(SplFileObject::READ_CSV);
        $file->setCsvControl($separator, $enclosure, $escape);
        foreach ($data as $fields) {
            $file->fputcsv($fields);
        }
        $file->rewind();

        return $file;
    }

    /**
     * @param FrozenTime $date
     * @return  string
     */
    public static function dateFormat(FrozenTime $date): string
    {
        return $date->setTimezone(new DateTimeZone('GMT'))
            ->format(DateTimeInterface::ATOM);
    }

    /**
     * Returns default User-Agent of PHP SDK
     *
     * @param string $suffix
     * @return  string
     */

    public static function defaultUserAgent(string $suffix = ''): string
    {
        $userAgent = 'API-PHP-SDK/1.0';

        if ($suffix) {
            $userAgent .= ' ' . ltrim($suffix, ' ');
        }

        return $userAgent;
    }

    /**
     * Converts undescore string to Pascal Case
     * For example: 'my_class' to 'MyClass'
     *
     * @param string $str
     * @return  string
     */
    public static function pascalize(string $str): string
    {
        return str_replace(' ', '', ucwords(strtr($str, '_-', '  ')));
    }

    /**
     * Converts word into the underscore format
     * For example 'CustomValue' becomes 'custom_value'
     *
     * @param string $str
     * @return  string
     */
    public static function underscorize(string $str): string
    {
        return strtolower(trim(preg_replace('/([A-Z]|[0-9]+)/', "_$1", $str), '_'));
    }

    /**
     * Converts specified response to a readable/downloadable file
     *
     * @param ResponseInterface $response
     * @param string $extension
     * @return  FileWrapper
     */
    public static function parseFileResponse(ResponseInterface $response, string $extension): FileWrapper
    {
        $contents = trim((string)$response->getBody());

        $file = (new FileWrapper($contents))->setFileExtension($extension);
        if ($extension == 'csv') {
            $file->getFile()->setFlags(SplFileObject::READ_CSV);
            $file->getFile()->setCsvControl(';');
        }

        if ($contentType = $response->getHeaderLine('Content-Type')) {
            $file->setContentType($contentType);
        }

        if ($contentDisposition = $response->getHeaderLine('Content-Disposition')) {
            preg_match('#.*filename="(.*)"$#i', $contentDisposition, $matches);
            if (!empty($matches) && isset($matches[1])) {
                $file->setFileName($matches[1]);
                $file->setFileExtension(pathinfo($matches[1], PATHINFO_EXTENSION), false);
            }
        }

        return $file;
    }

    /**
     * Converts specified JSON response to array
     *
     * @param ResponseInterface $response
     * @param bool $assoc
     * @return  array|\stdClass
     * @throws  \InvalidArgumentException
     */
    public static function parseJsonResponse(ResponseInterface $response, bool $assoc = true): array|\stdClass
    {
        $json = trim((string)$response->getBody());
        if (empty($json)) {
            return []; // fallback for empty response
        }
        return Utils::jsonDecode($json, $assoc);
    }

    /**
     * Converts specified XML response to array
     *
     * @param ResponseInterface $response
     * @param bool $assoc
     * @return  array|\stdClass
     * @throws  \InvalidArgumentException
     */
    public static function parseXmlResponse(ResponseInterface $response, bool $assoc = true): array|\stdClass
    {
        $xml = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($xml === false) {
            throw new InvalidArgumentException('XML can not be read');
        }
        $json = Utils::jsonEncode($xml);

        return Utils::jsonDecode($json, $assoc);
    }

    /**
     * Formats references associative array to query parameter
     *
     * @param array $data
     * @param string $entrySeparator
     * @param string $refSeperator
     * @return  string
     */
    public static function refsToQueryParam(array $data, string $entrySeparator = '|', string $refSeperator = ','): string
    {
        $params = [];
        foreach ($data as $key => $values) {
            $values = (array)$values;
            foreach ($values as $value) {
                $params[] = $key . $entrySeparator . $value;
            }
        }

        return implode($refSeperator, $params);
    }

    /**
     * Formats multiple array values to query parameter
     *
     * @param array $data
     * @param string $entrySeparator
     * @param string $refSeperator
     * @return  string
     */
    public static function tuplesToQueryParam(array $data, string $entrySeparator = '|', string $refSeperator = ','): string
    {
        $params = [];
        foreach ($data as $values) {
            $params[] = implode($entrySeparator, (array)$values);
        }
        return implode($refSeperator, $params);
    }
}
