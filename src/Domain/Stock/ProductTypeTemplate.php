<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\LastVersionTrait;
use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method  string  getAlias()
 * @method  string  getLabel()
 * @method  DateTime  getUpdateDate()
 * @method  ProductTypeTemplateAttributes getAttributes()
 */
class ProductTypeTemplate extends BaseObject
{
    use LastVersionTrait;

    protected static array $mapping = [
        'prdtypelabel' => 'label',
        'updatedate' => 'update_date'
    ];

    protected static array $dataTypes = [
        'attributes' => [ProductTypeTemplateAttributes::class, 'create']
    ];
}
