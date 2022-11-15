<?php

namespace RakutenSDK\Domain\Shipping\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Shipping\ShippingType;

/**
 * @method  ShippingType   current()
 * @method  ShippingType   first()
 * @method  ShippingType   get($offset)
 * @method  ShippingType   offsetGet($offset)
 * @method  ShippingType   last()
 * @method  ShippingType[] getIterator()
 */
class ShippingTypeCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = ShippingType::class;
}
