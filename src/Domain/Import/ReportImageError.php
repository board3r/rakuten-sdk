<?php

namespace RakutenSDK\Domain\Import;

use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method  string  getUrlImg()
 * @method  string  getAdvertId()
 * @method  string  getDetail()
 * @method  string  hasFatalError()

 */
class ReportImageError extends BaseObject
{
    public static array $mapping = [
        'urlimg' => 'url_img',
        'advertid' => 'advert_id'
    ];
}
