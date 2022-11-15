<?php

namespace RakutenSDK\Core\Response\Decorator;

use Psr\Http\Message\ResponseInterface;

class CsvCollection extends CsvArray
{
    /**
     * @var string
     */
    protected string $class;

    /**
     * @param string $class
     */
    public function __construct(string $class = \RakutenSDK\Core\Domain\Collection\BaseCollection::class)
    {
        $this->class = $class;
    }

    /**
     * @inheritdoc
     */
    public function decorate(ResponseInterface $response):mixed
    {
        $data = parent::decorate($response);

        return new $this->class($data);
    }
}
