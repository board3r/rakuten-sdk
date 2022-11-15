<?php

namespace RakutenSDK\Core\Response\Decorator;

use Psr\Http\Message\ResponseInterface;
use RakutenSDK\Core\Exception\ApiException;

trait ErrorTrait
{
    /**
     * @throws \RakutenSDK\Core\Exception\ApiException
     */
    protected function beforeDecorate(ResponseInterface $response)
    {
        if ($response->getStatusCode() <> 200) {
            throw new ApiException($response->getStatusCode(), $response->getReasonPhrase());
        }
    }

    protected function afterDecorate(array $data): array
    {
        if (isset($data['error'])) {
            $exceptionClassName = "\\Rakuten\\Sdk\\Core\\Exception\\ApiException";
            if (class_exists("\\Rakuten\\Sdk\\Core\\Exception\\" . $data['error']['code'] . "Exception")) {
                $exceptionClassName = "\\Rakuten\\Sdk\\Core\\Exception\\" . $data['error']['code'] . "Exception";
            }
            throw new $exceptionClassName($data['error']['message'].implode(' ',$data['error']['details']));
        }
        return $data;
    }
}
