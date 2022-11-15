<?php

namespace RakutenSDK\Request\Shipping;

use JetBrains\PhpStorm\Pure;
use RakutenSDK\Core\Request\AbstractRequest;
use RakutenSDK\Core\Response\Decorator\BaseObject;
use RakutenSDK\Domain\Shipping\ShippingTypes;
use RakutenSDK\Request\RakutenInterface;
use RakutenSDK\Request\RakutenTrait;


class GetShippingTypesRequest extends AbstractRequest implements RakutenInterface
{
    use RakutenTrait;

    protected string $endpoint = '/sales_ws';

    public function __construct()
    {
        $this->setData('action','getavailableshippingtypes');
        $this->setVersion(['2013-06-25']);
        parent::__construct();
    }

    /**
     * @return \RakutenSDK\Core\Response\Decorator\BaseObject|\RakutenSDK\Domain\Shipping\ShippingTypes
     */
    #[Pure]
    public function getResponseDecorator(): BaseObject|ShippingTypes
    {
        return ShippingTypes::decorator('response');
    }
}
