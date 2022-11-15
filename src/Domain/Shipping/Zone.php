<?php

namespace RakutenSDK\Domain\Shipping;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Domain\Shipping\Collection\ZoneTypeCollection;

/**
 * @method string  getName()
 * @method ZoneTypeCollection getTypes()
 */
class Zone extends BaseObject
{
    protected static array $mapping = [
        'type' => 'types'
    ];

    protected static array $dataTypes = [
        'types' => [ZoneTypeCollection::class, 'create'],
    ];
}
