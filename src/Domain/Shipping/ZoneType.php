<?php

namespace RakutenSDK\Domain\Shipping;

use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method string  getName()
 * @method bool  getAuthorization()
 * @method float  getLeaderPrice()
 * @method float  getFollowPrice()
 */
class ZoneType extends BaseObject
{
    protected static array $dataTypes = [
        'authorization' => 'boolval',
        'leader_price' => 'floatval',
        'follower_price' => 'floatval',
    ];
}
