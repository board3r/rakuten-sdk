<?php

namespace RakutenSDK\Core\Client;

use Cake\I18n\FrozenTime;
use RakutenSDK\Core\Utility\Functions;
use GuzzleHttp;
use RakutenSDK\Core\Domain\ArrayableInterface;
use RakutenSDK\Core\Domain\Collection\FileCollection;
use RakutenSDK\Core\Domain\FileWrapper;
use RakutenSDK\Core\Exception\ClientDisabledException;
use RakutenSDK\Core\Request\RequestInterface;
use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Utils;
use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;
use SplFileObject;

abstract class AbstractApiClient implements ApiClientInterface
{
    /**
     * @var string
     */
    protected string $baseUrl;

    /**
     * @var ?LoggerInterface
     */
    protected ?LoggerInterface $logger;

    /**
     * @var ?GuzzleHttp\MessageFormatter
     */
    protected ?GuzzleHttp\MessageFormatter $messageFormatter;

    /**
     * @var string
     */
    protected string $userAgent;

    /**
     * Won't send any request if client is disabled
     *
     * @var bool
     */
    protected bool $disabled = false;

    /**
     * Will return a promise response if enabled
     *
     * @var bool
     */
    protected bool $async = false;

    /**
     * Will return raw response if enabled
     *
     * @var bool
     */
    protected bool $raw = false;

    /**
     * Guzzle client object
     *
     * @var ?GuzzleHttp\ClientInterface
     */
    protected ?GuzzleHttp\ClientInterface $client;

    /**
     * Requests history storage
     *
     * @var array
     */
    protected array $history = [];

    /**
     * Request options
     *
     * @var array
     */
    protected array $options = ['connect_timeout' => 5];

    /**
     * Handle query parameters that will be merged
     * with request parameters when executed
     *
     * @var array
     */
    public array $queryParams = [];

    /**
     * @param string $name
     * @param array $args
     * @return  mixed
     * @throws  \Exception
     */
    public function __call(string $name, array $args)
    {
        /** @var RequestInterface $request */
        $request = $args[0];
        if (!$request instanceof RequestInterface) {
            throw new InvalidArgumentException('First parameter must be an instance of ' . RequestInterface::class);
        }

        return $this->execute($request);
    }

    /**
     * Proxy to run() method
     *
     * @param RequestInterface $request
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface
     * @throws \RakutenSDK\Core\Exception\ClientDisabledException
     */
    public function __invoke(RequestInterface $request): GuzzleHttp\Promise\PromiseInterface|ResponseInterface
    {
        return $this->execute($request);
    }

    /**
     * Add a request option
     *
     * @param string $key
     * @param mixed $value
     * @return  $this
     */
    public function addOption(string $key, mixed $value): static
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @param bool $flag
     * @return  $this
     */
    public function async(bool $flag = true): static
    {
        $this->async = $flag;

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return  array
     */
    public function buildRequestOptions(RequestInterface $request): array
    {
        // Build Guzzle request options
        $options = array_merge_recursive($this->options, $request->getOptions());

        $queryParams = $this->queryParams + $request->getQueryParams();

        if ($request->haveQueryParamsDuplicated()) {
            // If query params are duplicated, specify them as string to Guzzle
            $simpleParams = array_diff_key($queryParams, array_flip($request->getDuplicatedQueryParams()));
            $duplicatedParams = array_intersect_key($queryParams, array_flip($request->getDuplicatedQueryParams()));

            $options['query'] = Query::build(array_merge($this->formatQueryParams($simpleParams), $duplicatedParams));
        } else {
            $options['query'] = $this->formatQueryParams($queryParams);
        }

        $bodyParams = $request->getBodyParams();

        if (!empty($bodyParams)) {
            if ($request->isJSON()) {
                $options['json'] = $this->formatBodyParamsJson($bodyParams);
            } else {
                $options['multipart'] = $this->formatBodyParamsMultipart($bodyParams);
            }
        }

        if (!isset($options['headers'])) {
            $options['headers'] = [];
        }

        $options['headers']['X-API-Sdk-Uuid'] = uniqid('sdk_php_', true);

        return $options;
    }

    /**
     * @param bool $flag
     * @return  $this
     */
    public function disable(bool $flag = true): static
    {
        $this->disabled = $flag;

        return $this;
    }

    /**
     * Executes specified request taking raw and async parameters into account
     *
     * @param RequestInterface $request
     * @return  mixed
     * @throws \RakutenSDK\Core\Exception\ClientDisabledException
     */
    private function execute(RequestInterface $request): mixed
    {
        if ($this->async) {
            return $this->runAsync($request);
        }

        return $this->raw ? $this->run($request) : $request->run($this);
    }

    /**
     * Formats body parameters for JSON requests
     *
     * @param array $bodyParams
     * @return  array
     */
    private function formatBodyParamsJson(array $bodyParams): array
    {
        $params = [];
        foreach ($bodyParams as $key => $value) {
            if ($value instanceof SimpleXMLElement) {
                // Handle XML fields
                $value = $value->asXML();
            } elseif ($value instanceof ArrayableInterface) {
                $value = $value->toArray();
            }
            $params[$key] = $value;
        }

        return $params;
    }

    /**
     * Formats body parameters for multipart requests
     *
     * @param array $bodyParams
     * @return  array
     */
    private function formatBodyParamsMultipart(array $bodyParams): array
    {
        $params = [];
        foreach ($bodyParams as $key => $value) {
            $headers = [];

            // Wrap \SplFileObject into a file object
            if ($value instanceof SplFileObject) {
                $value = new FileWrapper($value);
            }

            // Handle single file in a file collection to use just after
            if ($value instanceof FileWrapper) {
                $value = (new FileCollection)->add($value);
            }

            // Handle files upload
            if ($value instanceof FileCollection) {
                foreach ($value as $file) {
                    $params[] = $this->formatPostFile($key, $file);
                }
                continue;
            }

            if ($value instanceof SimpleXMLElement) {
                // Handle XML fields
                $value = $value->asXML();
            } elseif (is_array($value)) {
                // Handle other array fields as JSON
                $value = json_encode($value);
                $headers['Content-Type'] = 'application/json;charset=utf-8';
            } elseif (is_bool($value)) {
                // Convert boolean values to string manually because of Guzzle casting them to '0' or '1'
                $value = $value ? 'true' : 'false';
            }

            $params[] = [
                'name' => $key,
                'contents' => (string)$value,
                'headers' => $headers,
            ];
        }

        return $params;
    }

    /**
     * Formats file information for request
     *
     * @param string $name
     * @param FileWrapper $file
     * @return  array
     */
    #[ArrayShape(['name' => "string", 'filename' => "string", 'contents' => "false|string", 'headers' => "string[]"])]
    private function formatPostFile(string $name, FileWrapper $file): array
    {
        $file->getFile()->rewind();

        return [
            'name' => $name,
            'filename' => $file->getFileName(),
            'contents' => @$file->getFile()->fread($file->getFile()->fstat()['size']),
            'headers' => ['Content-Type' => 'application/octet-stream'],
        ];
    }

    /**
     * Formats params as query string params
     *
     * @param array $params
     * @return  array
     */
    private function formatQueryParams(array $params): array
    {
        foreach ($params as $key => $value) {
            if ($value instanceof FrozenTime) {
                $value = Functions::dateFormat($value);
            } elseif (is_array($value)) {
                if (Functions::arrayIsAssoc($value)) {
                    array_walk($value, function (&$val, $key) {
                        $val = $key . '|' . $val;
                    });
                }
                $value = implode(',', $value);
            }
            $params[$key] = $value;
        }

        return $params;
    }


    /**
     * @return  string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return  ?LoggerInterface
     */
    public function getLogger(): ?LoggerInterface
    {
        if (isset($this->logger)){
            return $this->logger;
        }
        return null;
    }

    /**
     * @return  GuzzleHttp\MessageFormatter
     */
    public function getMessageFormatter(): GuzzleHttp\MessageFormatter
    {
        if (empty($this->messageFormatter)) {
            $this->messageFormatter = new GuzzleHttp\MessageFormatter();
        }

        return $this->messageFormatter;
    }

    /**
     * @return \GuzzleHttp\Client|\GuzzleHttp\ClientInterface
     */
    public function getClient(): GuzzleHttp\Client|GuzzleHttp\ClientInterface
    {
        if (!isset($this->client)) {
            $this->client = $this->getDefaultClient();
        }

        return $this->client;
    }

    /**
     * @return  GuzzleHttp\Client
     */
    protected function getDefaultClient(): GuzzleHttp\Client
    {
        $stack = GuzzleHttp\HandlerStack::create();
        $stack->push(GuzzleHttp\Middleware::history($this->history));

        $logger = $this->getLogger();
        if (!empty($logger)) {
            $stack->push(GuzzleHttp\Middleware::log($logger, $this->getMessageFormatter()));
        }

        return new GuzzleHttp\Client([
            'handler' => $stack,
            'base_uri' => rtrim($this->getBaseUrl(), '/') . '/',
            'headers' => [
                'User-Agent' => $this->getUserAgent() ?: static::getDefaultUserAgent(),
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * @return  string
     */
    #[Pure]
    public static function getDefaultUserAgent(): string
    {
        return Functions::defaultUserAgent(Utils::defaultUserAgent());
    }

    /**
     * Returns last request as a string for debugging purpose
     *
     * @return  string
     */
    public function getLastRequestString(): string
    {
        return !empty($this->history) ? Message::toString(current($this->history)['request']) : '';
    }

    /**
     * Returns all request options
     *
     * @return  array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return  string
     */
    public function getUserAgent(): string
    {
        if (!isset($this->userAgent)){
            $this->userAgent = self::getDefaultUserAgent();
        }
        return $this->userAgent;
    }

    /**
     * Prepares and builds request promise before being executed
     *
     * @param RequestInterface $request
     * @return  GuzzleHttp\Promise\PromiseInterface
     */
    private function prepareRequest(RequestInterface $request): GuzzleHttp\Promise\PromiseInterface
    {
        return $this->getClient()->requestAsync(
            $request->getMethod(), $request->getUri(), $this->buildRequestOptions($request)
        );
    }

    /**
     * @param bool $flag
     * @return  $this
     */
    public function raw(bool $flag = true): static
    {
        $this->raw = $flag;

        return $this;
    }

    /**
     * Removes a specific option by key
     *
     * @param string $key
     * @return  $this
     */
    public function removeOption(string $key): static
    {
        if (isset($this->options[$key])) {
            unset($this->options[$key]);
        }

        return $this;
    }

    /**
     * Prepares and executes given request
     *
     * @param RequestInterface $request
     * @return  ResponseInterface
     * @throws \RakutenSDK\Core\Exception\ClientDisabledException
     */
    public function run(RequestInterface $request): ResponseInterface
    {
        return $this->runAsync($request)->wait();
    }

    /**
     * Prepares given request without executing it
     *
     * @param RequestInterface $request
     * @return  GuzzleHttp\Promise\PromiseInterface
     * @throws  ClientDisabledException
     */
    public function runAsync(RequestInterface $request): GuzzleHttp\Promise\PromiseInterface
    {
        if ($this->disabled) {
            throw new ClientDisabledException('API client is disabled');
        }

        return $this->prepareRequest($request);
    }

    /**
     * @param string $baseUrl
     * @return  $this
     */
    public function setBaseUrl(string $baseUrl): static
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @param LoggerInterface $logger
     * @param \GuzzleHttp\MessageFormatter|null $messageFormatter
     * @return  $this
     */
    public function setLogger(LoggerInterface $logger, GuzzleHttp\MessageFormatter $messageFormatter = null): static
    {
        $this->logger = $logger;
        $this->messageFormatter = $messageFormatter;

        return $this;
    }

    /**
     * @param GuzzleHttp\MessageFormatter $messageFormatter
     * @return  $this
     */
    public function setMessageFormatter(GuzzleHttp\MessageFormatter $messageFormatter): static
    {
        $this->messageFormatter = $messageFormatter;

        return $this;
    }

    /**
     * @param GuzzleHttp\ClientInterface $client
     * @return  $this
     */
    public function setClient(GuzzleHttp\ClientInterface $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Overrides all request options by specified ones
     *
     * @param array $options
     * @return  $this
     */
    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param string $userAgent
     * @return  $this
     */
    public function setUserAgent(string $userAgent): static
    {
        $this->userAgent = $userAgent;

        return $this;
    }
}
