<?php

namespace RakutenSDK\Request\Stock;

use JetBrains\PhpStorm\Pure;
use RakutenSDK\Core\Request\AbstractRequest;
use RakutenSDK\Core\Response\Decorator\BaseCollection;
use RakutenSDK\Domain\Stock\Collection\ProductTypeCollection;
use RakutenSDK\Request\RakutenInterface;
use RakutenSDK\Request\RakutenTrait;

class GetProductTypesRequest extends AbstractRequest implements RakutenInterface
{
    use RakutenTrait;

    protected string $endpoint = '/stock_ws';

    public function __construct()
    {
        $this->setData('action','producttypes');
        $this->setVersion(['2015-06-30', '2011-11-29']);
        parent::__construct();
    }

    /**
     * @return \RakutenSDK\Core\Response\Decorator\BaseCollection|\RakutenSDK\Domain\Stock\Collection\ProductTypeCollection
     */
    #[Pure]
    public function getResponseDecorator(): BaseCollection|ProductTypeCollection
    {
        return ProductTypeCollection::decorator('response.producttypetemplate');
    }
}
