<?php

namespace RakutenSDK\Domain\Stock\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Stock\ListingCategory;

/**
 * @method  ListingCategory   current()
 * @method  ListingCategory   first()
 * @method  ListingCategory   get($offset)
 * @method  ListingCategory   offsetGet($offset)
 * @method  ListingCategory   last()
 * @method  ListingCategory[] getIterator()
 */
class ListingCategoryCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = ListingCategory::class;
}
