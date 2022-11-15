<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method  string getLabel()
 * @method  string getUrl()
 * @method  int getResultCount()
 */
class ListingCategory extends BaseObject
{
    public static array $mapping = [
        'link/label' => 'label',
        'link/url' => 'url',
        'resultcount' => 'result_count',
    ];

    protected static array $dataTypes = [
        'result_count' => 'intval',
    ];
}
