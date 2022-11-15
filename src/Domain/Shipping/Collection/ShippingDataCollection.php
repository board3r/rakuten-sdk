<?php

namespace RakutenSDK\Domain\Shipping\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Shipping\ShippingData;

/**
 * @method  ShippingData   current()
 * @method  ShippingData   first()
 * @method  ShippingData   get($offset)
 * @method  ShippingData   offsetGet($offset)
 * @method  ShippingData   last()
 * @method  ShippingData[] getIterator()
 */
class ShippingDataCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = ShippingData::class;
}
