<?php

namespace RakutenSDK\Domain\Common\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Common\Attribute;

/**
 * @method  Attribute   current()
 * @method  Attribute   first()
 * @method  Attribute   get($offset)
 * @method  Attribute   offsetGet($offset)
 * @method  Attribute   last()
 * @method  Attribute[] getIterator()
 */
class AttributeCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = Attribute::class;
}
