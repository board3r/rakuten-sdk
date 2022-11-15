<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method  ListingProductOffer getGlobal()
 * @method  ListingProductOffer getNew()
 * @method  ListingProductOffer getUsed()
 * @method  ListingProductOffer getCollectible()
 */
class ListingProductOffers extends BaseObject
{
    protected static array $dataTypes = [
        'global' => [ListingProductOffer::class, 'create'],
        'new' => [ListingProductOffer::class, 'create'],
        'used' => [ListingProductOffer::class, 'create'],
        'collectible' => [ListingProductOffer::class, 'create'],
    ];
}
