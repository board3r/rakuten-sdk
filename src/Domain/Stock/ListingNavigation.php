<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Domain\Stock\Collection\ListingCategoryCollection;

/**
 * @method  string getSelectedCategory()
 * @method  ListingCategoryCollection getCategories()
 */
class ListingNavigation extends BaseObject
{
    public static array $mapping = [
        'selectedcategory' => 'selected_category',
        'categories/category' => 'categories',
    ];

    protected static array $dataTypes = [
        'categories' => [ListingCategoryCollection::class, 'create'],
    ];
}
