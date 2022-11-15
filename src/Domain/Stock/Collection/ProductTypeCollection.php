<?php

namespace RakutenSDK\Domain\Stock\Collection;

use RakutenSDK\Core\Domain\Collection\BaseCollection;
use RakutenSDK\Domain\Stock\ProductType;

/**
 * @method  ProductType   current()
 * @method  ProductType   first()
 * @method  ProductType   get($offset)
 * @method  ProductType   offsetGet($offset)
 * @method  ProductType   last()
 * @method  ProductType[] getIterator()
 */
class ProductTypeCollection extends BaseCollection
{
    /**
     * @var string|null
     */
    protected ?string $itemClass = ProductType::class;
}
