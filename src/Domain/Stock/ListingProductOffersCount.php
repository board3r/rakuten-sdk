<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method  bool hasTotal()
 * @method  bool hasNew()
 * @method  bool hasUsed()
 * @method  bool hasCollectible()
 * @method  bool hasRefurbishedNew()
 * @method  bool hasRefurbishedUsed()
 * @method  int getTotal()
 * @method  int getNew()
 * @method  int geUsed()
 * @method  int getCollectible()
 * @method  int getRefurbishedNew()
 * @method  int getRefurbishedUsed()
 */
class ListingProductOffersCount extends BaseObject
{
    protected static array $mapping = [
        'refurbishedNew' => 'refurbishe_new',
        'refurbishedUsed' => 'refurbishe_used'
    ];
    protected static array $dataTypes = [
        'total' => 'intval',
        'new' => 'intval',
        'used' => 'intval',
        'collectible' => 'intval',
        'refurbishe_new' => 'intval',
        'refurbishe_used' => 'intval',
    ];
}
