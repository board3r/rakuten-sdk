<?php

namespace RakutenSDK\Request\Sale;

use JetBrains\PhpStorm\Pure;
use RakutenSDK\Core\Request\AbstractRequest;
use RakutenSDK\Core\Response\Decorator\BaseCollection;
use RakutenSDK\Core\Response\Decorator\BaseObject;
use RakutenSDK\Domain\Stock\Category;
use RakutenSDK\Request\RakutenInterface;
use RakutenSDK\Request\RakutenTrait;

class GetNewSalesRequest extends AbstractRequest implements RakutenInterface
{
    use RakutenTrait;

    protected string $endpoint = '/sales_ws';

    public function __construct()
    {
        $this->setData('action', 'getnewsales');
        $this->setVersion(['2017-08-07','2016-03-16','2014-02-11']);
        parent::__construct();
    }

    /**
     * @return \RakutenSDK\Core\Response\Decorator\BaseCollection|\RakutenSDK\Request\Sale\SaleCollection
     */
    #[Pure]
    public function getResponseDecorator(): BaseCollection|SaleCollection
    {
        return SaleCollection::decorator('response.sales');
    }

}
