<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Domain\Stock\Collection\ListingProductBreadcrumbCollection;

/**
 * @method int getProductId()
 * @method int getCategory()
 * @method string getAlias()
 * @method string getHeadLine()
 * @method string getCaption()
 * @method string getTopic()
 * @method ListingProductOffersCount getOfferCounts()
 * @method string getUrl()
 * @method ListingProductReference getReferences()
 * @method bool hasBestPrices()
 * @method ListingProductOffers getBestPrices()
 * @method bool hasReviews()
 * @method ListingProductReviews getReviews()
 * @method ListingProductBreadcrumbCollection getBreadcrumbs()
 */
class ListingProduct extends BaseObject
{

    public function __construct(array $data = [])
    {
        // clean empty custom shipping types
        if (isset($data['reviews']) && !$data['reviews']) unset($data['reviews']);
        if (isset($data['best_prices']) && !$data['best_prices']) unset($data['best_prices']);
        parent::__construct($data);
    }

    public static array $mapping = [
        'productid' => 'product_id',
        'headline' => 'head_line',
        'offercounts' => 'offer_counts',
        'bestprices' => 'best_prices',
        'image/url' => 'images',
        'breadcrumbselements/breadcrumbselement' => 'breadcrumbs',
    ];

    protected static array $dataTypes = [
        'offer_counts' => [ListingProductOffersCount::class, 'create'],
        'best_prices' => [ListingProductOffers::class, 'create'],
        'reviews' => [ListingProductReviews::class, 'create'],
        'breadcrumbs' => [ListingProductBreadcrumbCollection::class, 'create'],
        'references' => [ListingProductReference::class, 'create'],
    ];

    public function setImages(null|array|string $data): static
    {
        if (!$data){
            $this->setData('images',null);
        }else if (is_array($data)){
            $this->setData('images',$data);
        }else if (is_string($data)){
            $this->setData('images',[$data]);
        }

        return $this;
    }
}

