<?php

namespace RakutenSDK\Domain\Import\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Import\ReportError;

/**
 * @method  ReportError   current()
 * @method  ReportError   first()
 * @method  ReportError   get($offset)
 * @method  ReportError   offsetGet($offset)
 * @method  ReportError   last()
 * @method  ReportError[] getIterator()
 */
class ReportErrorCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = ReportError::class;
}
