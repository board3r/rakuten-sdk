<?php
namespace RakutenSDK\Core\Response\Decorator;

use RakutenSDK\Core\Response\ResponseDecoratorInterface;
use Psr\Http\Message\ResponseInterface;

class ArrayValue implements ResponseDecoratorInterface
{
    /**
     * @var string
     */
    protected string $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @inheritdoc
     */
    public function decorate(ResponseInterface $response):mixed
    {
        return (new AssocArray())->decorate($response)[$this->key];
    }
}
