<?php
namespace RakutenSDK\Core\Response\Decorator;

use RakutenSDK\Core\Response\ResponseDecoratorInterface;
use RakutenSDK\Core\Utility\Functions;
use Psr\Http\Message\ResponseInterface;

class CsvArray implements ResponseDecoratorInterface
{
    /**
     * @inheritdoc
     */
    public function decorate(ResponseInterface $response): mixed
    {
        $data = [];

        /** @var \RakutenSDK\Core\Domain\FileWrapper $csvFile */
        if ($csvFile = (new File('csv'))->decorate($response)) {
            $file = $csvFile->getFile();
            $cols = $file->fgetcsv(); // First line contains columns
            while (!$file->eof()) {
                // Maps columns with values
                $data[] = array_combine($cols, Functions::arrayFormat($file->fgetcsv()));
            }
        }

        return $data;
    }
}
