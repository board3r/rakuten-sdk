<?php

namespace RakutenSDK\Request\Stock;

use JetBrains\PhpStorm\Pure;
use RakutenSDK\Core\Request\AbstractRequest;
use RakutenSDK\Core\Response\Decorator\BaseObject;
use RakutenSDK\Domain\Stock\Listing;
use RakutenSDK\Request\RakutenInterface;
use RakutenSDK\Request\RakutenTrait;

/**
 * @method null|string getScope()
 * @method GetListingRequest setScope(?string $scope)
 * @method null|string getCategory()
 * @method GetListingRequest setCategory(?string $category)
 */
class GetListingRequest extends AbstractRequest implements RakutenInterface
{
    use RakutenTrait;

    const SCOPE_PRICING = 'PRICING';
    const SCOPE_LIMITED = 'LIMITED';

    public array $queryParams = ['scope', 'kw', 'nav', 'withstock', 'refs', 'productids', 'nbproductsperpage', 'pagenumber'];

    protected string $endpoint = '/listing_ssl_ws';

    public function __construct(?string $keywords = null, ?string $category = null, ?array $refs = null, ?array $productIds = null, ?string $scope = null, int $nbProductsPerPage = 20, int $pageNumber = 1, ?bool $sameOrdeAsPlatform = null)
    {
        $this->setData('action', 'listing');
        $this->setVersion(['2018-06-28', '2015-07-05']);
        $data = [
            'scope' => (
            ($scope == GetListingRequest::SCOPE_PRICING) ? GetListingRequest::SCOPE_PRICING : (
            ($scope == GetListingRequest::SCOPE_LIMITED) ? GetListingRequest::SCOPE_LIMITED : null)
            ),
            'kw' => $keywords,
            'nav' => $category,
            'withstock' => $sameOrdeAsPlatform,
            'refs' => $refs,
            'productids' => $productIds,
            'nbproductsperpage' => $nbProductsPerPage,
            'pagenumber' => $pageNumber,
        ];
        parent::__construct($data);
    }

    /**
     * @return \RakutenSDK\Core\Response\Decorator\BaseObject|\RakutenSDK\Domain\Stock\Export
     */
    #[Pure]
    public function getResponseDecorator(): BaseObject|Listing
    {
        return Listing::decorator('response');
    }

    /**
     * @return ?string
     */
    public function getKeywords(): ?string
    {
        return $this->getData('kw');
    }

    /**
     * @param string|null $value
     * @return \RakutenSDK\Request\Stock\GetListingRequest
     */
    public function setKeywords(?string $value): static
    {
        return $this->setData('kw', $value);
    }

    /**
     * @return ?bool
     */
    public function getWithStock(): ?bool
    {
        return $this->getData('withstock');
    }

    /**
     * @param null|bool $value
     * @return \RakutenSDK\Request\Stock\GetListingRequest
     */
    public function setWithStock(?bool $value): static
    {
        return $this->setData('withstock', $value);
    }

    /**
     * @return ?array
     */
    public function getProductIds(): ?array
    {
        return $this->getData('productids');
    }

    /**
     * @param array|null $value
     * @return \RakutenSDK\Request\Stock\GetListingRequest
     */
    public function settProductIds(?array $value): static
    {
        return $this->setData('productids', is_array($value ? implode(',', $value) : null));
    }

    /**
     * @return ?array
     */
    public function getRefs(): ?array
    {
        return $this->getData('productids');
    }

    /**
     * @param array|null $value
     * @return \RakutenSDK\Request\Stock\GetListingRequest
     */
    public function setRefs(?array $value): static
    {
        return $this->setData('refs', is_array($value) ? implode(',', $value) : null);
    }

    /**
     * @return int
     */
    public function getNbProductsPerPage(): int
    {
        return $this->getData('nbproductsperpage');
    }

    /**
     * @param int $value
     * @return \RakutenSDK\Request\Stock\GetListingRequest
     */
    public function setNbProductsPerPage(int $value): static
    {
        return $this->setData('nbproductsperpage');
    }

    /**
     * @return int
     */
    public function getPageNumber(): int
    {
        return $this->getData('pagenumber');
    }

    /**
     * @param int $value
     * @return \RakutenSDK\Request\Stock\GetListingRequest
     */
    public function setPageNumber(int $value): static
    {
        return $this->setData('pagenumber');
    }
}
