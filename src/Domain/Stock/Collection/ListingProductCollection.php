<?php

namespace RakutenSDK\Domain\Stock\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Stock\ListingProduct;

/**
 * @method  ListingProduct   current()
 * @method  ListingProduct   first()
 * @method  ListingProduct   get($offset)
 * @method  ListingProduct   offsetGet($offset)
 * @method  ListingProduct   last()
 * @method  ListingProduct[] getIterator()
 */
class ListingProductCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = ListingProduct::class;
}
