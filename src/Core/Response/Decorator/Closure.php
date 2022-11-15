<?php

namespace RakutenSDK\Core\Response\Decorator;

use RakutenSDK\Core\Response\ResponseDecoratorInterface;
use Psr\Http\Message\ResponseInterface;

class Closure implements ResponseDecoratorInterface
{
    /**
     * @var \Closure
     */
    protected \Closure $closure;

    /**
     * @param \Closure $closure
     */
    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @inheritdoc
     */
    public function decorate(ResponseInterface $response):mixed
    {
        return call_user_func_array($this->closure, [$response]);
    }
}
