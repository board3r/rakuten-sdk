<?php

namespace RakutenSDK\Domain\Shipping;

use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method string  getPickupStoreId()
 * @method int  getQty()
 */
class PickupStore extends BaseObject
{
    protected static array $mapping = [
        'pickupstoreid' => 'pickup_store_id'
    ];

    protected static array $dataTypes = [
        'qty' => 'intval',
    ];
}
