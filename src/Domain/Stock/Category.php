<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Core\Domain\LastVersionTrait;
use RakutenSDK\Domain\Stock\Collection\CategoryCollection;

/**
 * @method  string  getCode()
 * @method  bool  hasCategories()
 * @method  CategoryCollection  getCategories()
 */
class Category extends BaseObject
{
    use LastVersionTrait;

    public static array $mapping = [
        'categories/category' => 'categories',
        'category' => 'categories',
    ];
    protected static array $dataTypes = [
        'categories' => [CategoryCollection::class, 'create']
    ];
}
