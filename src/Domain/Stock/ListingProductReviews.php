<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method  float getAverage()
 * @method  int getCount()
 */
class ListingProductReviews extends BaseObject
{
    public static array $mapping = [
        'averagenote' => 'average',
    ];

    protected static array $dataTypes = [
        'average' =>'floatval',
        'count' =>'intval',
    ];
}
