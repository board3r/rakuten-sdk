<?php

namespace RakutenSDK\Domain\Shipping\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Shipping\ZoneType;

/**
 * @method  ZoneType   current()
 * @method  ZoneType   first()
 * @method  ZoneType   get($offset)
 * @method  ZoneType   offsetGet($offset)
 * @method  ZoneType   last()
 * @method  ZoneType[] getIterator()
 */
class ZoneTypeCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = ZoneType::class;
}
