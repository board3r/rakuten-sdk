<?php

namespace RakutenSDK\Domain\Shipping;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Core\Domain\LastVersionTrait;
use RakutenSDK\Domain\Shipping\Collection\ShippingTypeCollection;

/**
 * @method string  getName()
 * @method ShippingTypeCollection  getBasicTypes()
 * @method ShippingTypeCollection  getCustomTypes()
 * @method bool  hasCustomTypes()
 */
class ShippingTypes extends BaseObject
{
    use LastVersionTrait;

    public function __construct(array $data = [])
    {
        // clean empty custom shipping types
        if (isset($data['custom_types']) && !$data['custom_types']) unset($data['custom_types']);
        parent::__construct($data);
    }

    protected static array $mapping = [
        'basic_types/mode' => 'basic_types',
        'custom_types/mode' => 'custom_types'
    ];
    protected static array $dataTypes = [
        'basic_types' => [ShippingTypeCollection::class, 'create'],
        'custom_types' => [ShippingTypeCollection::class, 'create'],
    ];
}
