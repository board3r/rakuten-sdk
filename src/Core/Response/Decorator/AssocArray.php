<?php
namespace RakutenSDK\Core\Response\Decorator;

use RakutenSDK\Core\Exception\ApiException;
use RakutenSDK\Core\Response\ResponseDecoratorInterface;
use RakutenSDK\Core\Utility\Functions;
use Psr\Http\Message\ResponseInterface;

class AssocArray implements ResponseDecoratorInterface
{
    /**
     * @inheritdoc
     * @throws \RakutenSDK\Core\Exception\ApiException
     */
    public function decorate(ResponseInterface $response): mixed
    {
        if (str_starts_with($response->getHeaderLine('Content-Type'), 'application/xml') || str_starts_with($response->getHeaderLine('Content-Type'), 'text/xml')) {
            return Functions::parseXmlResponse($response);
        }
        if (str_starts_with($response->getHeaderLine('Content-Type'), 'application/json')) {
            return Functions::parseJsonResponse($response);
        }
        throw new ApiException($response->getBody()->getContents());
    }
}
