<?php
namespace RakutenSDK\Core\Client;

use RakutenSDK\Core\Request\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ApiClientInterface
{
    /**
     * Runs specified request against current API
     *
     * @param   RequestInterface    $request
     * @return  ResponseInterface
     */
    public function run(RequestInterface $request): ResponseInterface;
}
