<?php

namespace RakutenSDK\Domain\Stock\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Stock\Category;

/**
 * @method  Category   current()
 * @method  Category   first()
 * @method  Category   get($offset)
 * @method  Category   offsetGet($offset)
 * @method  Category   last()
 * @method  Category[] getIterator()
 */
class CategoryCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = Category::class;
}
