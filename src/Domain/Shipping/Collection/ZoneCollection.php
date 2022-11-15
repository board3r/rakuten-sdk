<?php

namespace RakutenSDK\Domain\Shipping\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Shipping\Zone;

/**
 * @method  Zone   current()
 * @method  Zone   first()
 * @method  Zone   get($offset)
 * @method  Zone   offsetGet($offset)
 * @method  Zone   last()
 * @method  Zone[] getIterator()
 */
class ZoneCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = Zone::class;
}
