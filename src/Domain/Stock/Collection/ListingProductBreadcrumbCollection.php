<?php

namespace RakutenSDK\Domain\Stock\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Stock\ListingProductBreadcrumb;

/**
 * @method  ListingProductBreadcrumb   current()
 * @method  ListingProductBreadcrumb   first()
 * @method  ListingProductBreadcrumb   get($offset)
 * @method  ListingProductBreadcrumb   offsetGet($offset)
 * @method  ListingProductBreadcrumb   last()
 * @method  ListingProductBreadcrumb[] getIterator()
 */
class ListingProductBreadcrumbCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = ListingProductBreadcrumb::class;
}
