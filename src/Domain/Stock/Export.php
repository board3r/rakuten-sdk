<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Core\Domain\LastVersionTrait;

/**
 * @todo Not finish, need access to test and implement
 *
 * @method  string  getNextPageToken()
 */
class Export extends BaseObject
{
    use LastVersionTrait;

    public static array $mapping = [
        'nexttoken' => 'next_page_token',
    ];

}
