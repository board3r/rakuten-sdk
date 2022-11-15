<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Domain\Common\Collection\AttributeCollection;
use RakutenSDK\Domain\Shipping\Collection\PickupStoreCollection;
use RakutenSDK\Domain\Shipping\ShippingData;

/**
 * @method  AttributeCollection  getProduct()
 * @method  AttributeCollection  getAdvert()
 * @method  AttributeCollection  getMedia()
 * @method  AttributeCollection  getCampaigns()
 * @method  ShippingData getShipping()
 * @method  PickupStoreCollection getPickupStores()
 */
class ProductTypeTemplateAttributes extends BaseObject
{
    protected static array $mapping = [
        'advert/attribute' => 'advert',
        'media/attribute' => 'media',
        'product/attribute' => 'product',
        'campaigns/campaign/attribute' => 'campaign',
        'pickupstores/pickupstore' => 'pickup_stores',
    ];

    protected static array $dataTypes = [
        'product' => [AttributeCollection::class, 'create'],
        'advert' => [AttributeCollection::class, 'create'],
        'media' => [AttributeCollection::class, 'create'],
        'campaign' => [AttributeCollection::class, 'create'],
        'shipping' => [ShippingData::class, 'create'],
        'pickup_stores' => [PickupStoreCollection::class, 'create'],
    ];

}
