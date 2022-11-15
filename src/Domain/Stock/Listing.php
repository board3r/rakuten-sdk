<?php

namespace RakutenSDK\Domain\Stock;


use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Core\Domain\LastVersionTrait;
use RakutenSDK\Domain\Stock\Collection\ListingProductCollection;

/**
 * @method  int getTotalResultCount()
 * @method  int getResultCount()
 * @method  ListingNavigation getNavigation()
 * @method  ListingProductCollection getProducts()
 */
class Listing extends BaseObject
{
    use LastVersionTrait;

    public static array $mapping = [
        'totalresultcount' => 'total_result_count',
        'resultcount' => 'result_count',
        'products/product' => 'products'
    ];

    protected static array $dataTypes = [
        'navigation' => [ListingNavigation::class, 'create'],
        'products' => [ListingProductCollection::class, 'create'],
    ];
}
