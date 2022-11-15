<?php

namespace RakutenSDK\Domain\Import\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Import\ReportProduct;

/**
 * @method  ReportProduct   current()
 * @method  ReportProduct   first()
 * @method  ReportProduct   get($offset)
 * @method  ReportProduct   offsetGet($offset)
 * @method  ReportProduct   last()
 * @method  ReportProduct[] getIterator()
 */
class ReportProductCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = ReportProduct::class;
}
