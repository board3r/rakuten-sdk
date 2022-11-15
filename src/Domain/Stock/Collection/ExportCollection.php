<?php

namespace RakutenSDK\Domain\Stock\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Stock\Export;

/**
 * @method  Export   current()
 * @method  Export   first()
 * @method  Export   get($offset)
 * @method  Export   offsetGet($offset)
 * @method  Export   last()
 * @method  Export[] getIterator()
 */
class ExportCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = Export::class;
}
