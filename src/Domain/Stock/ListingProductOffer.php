<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method  float getAmount()
 * @method  string getCurrency()
 * @method  float getShippingAmount()
 * @method  string getShippingCurrency()
 * @method  string getShippingType()
 */
class ListingProductOffer extends BaseObject
{
    public static array $mapping = [
        'advertprice/amount' => 'amount',
        'advertprice/currency' => 'currency',
        'shippingcost/amount' => 'shipping_amount',
        'shippingcost/currency' => 'shipping_currency',
        'shippingtype' => 'shipping_type',
    ];

    protected static array $dataTypes = [
        'amount' =>'floatval',
        'shipping_amount' =>'floatval',
    ];
}
