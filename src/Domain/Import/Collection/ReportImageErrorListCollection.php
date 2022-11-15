<?php

namespace RakutenSDK\Domain\Import\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Import\ReportImageError;

/**
 * @method  ReportImageError   current()
 * @method  ReportImageError   first()
 * @method  ReportImageError   get($offset)
 * @method  ReportImageError   offsetGet($offset)
 * @method  ReportImageError   last()
 * @method  ReportImageError[] getIterator()
 */
class ReportImageErrorListCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = ReportImageError::class;
}
