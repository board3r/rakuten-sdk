<?php

namespace RakutenSDK\Core\Response;

use Psr\Http\Message\ResponseInterface;

interface ResponseDecoratorInterface
{
    /**
     * @param ResponseInterface $response
     * @throws \RakutenSDK\Core\Exception\ApiException
     * @return  mixed
     */
    public function decorate(ResponseInterface $response): mixed;
}
