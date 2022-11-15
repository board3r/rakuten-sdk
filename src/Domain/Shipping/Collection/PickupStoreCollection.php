<?php

namespace RakutenSDK\Domain\Shipping\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Shipping\PickupStore;

/**
 * @method  PickupStore   current()
 * @method  PickupStore   first()
 * @method  PickupStore   get($offset)
 * @method  PickupStore   offsetGet($offset)
 * @method  PickupStore   last()
 * @method  PickupStore[] getIterator()
 */
class PickupStoreCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = PickupStore::class;
}
