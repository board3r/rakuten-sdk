<?php

namespace RakutenSDK\Domain\Shipping;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Domain\Shipping\Collection\ZoneCollection;

/**
 * @method string  getShippedByRsl()
 * @method string  getPackageWeight()
 * @method ZoneCollection  getZones()
 */
class ShippingData extends BaseObject
{
    protected static array $mapping = [
        'configuration/zone' => 'zones',
    ];

    protected static array $dataTypes = [
        'zones' => [ZoneCollection::class, 'create'],
    ];

}
