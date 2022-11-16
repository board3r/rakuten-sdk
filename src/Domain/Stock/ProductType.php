<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Core\Domain\LastVersionTrait;

/**
 * @method  string  getAlias()
 * @method  string  getLabel()
 * @method  string  getCategoryRef()
 * @method  \DateTime  getUpdateDate()
 */
class ProductType extends BaseObject
{
    use LastVersionTrait;

    protected static array $mapping = [
        'updatedate' => 'update_date'
    ];
}
