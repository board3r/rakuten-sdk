<?php

namespace RakutenSDK;

use GuzzleHttp\Psr7\Response;
use RakutenSDK\Core\Client\AbstractApiClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;


use RakutenSDK\Domain\Import\Import;
use RakutenSDK\Domain\Import\Report;
use RakutenSDK\Domain\Shipping\ShippingTypes;
use RakutenSDK\Domain\Stock\Category;
use RakutenSDK\Domain\Stock\Collection\CategoryCollection;
use RakutenSDK\Domain\Stock\Export;
use RakutenSDK\Domain\Stock\Listing;
use RakutenSDK\Domain\Stock\ProductTypeTemplate;
use RakutenSDK\Request\Import\GetGenericReportRequest;
use RakutenSDK\Request\Import\SendGenericFileRequest;
use RakutenSDK\Request\Shipping\GetShippingTypesRequest;
use RakutenSDK\Request\Stock\GetCategoriesRequest;
use RakutenSDK\Request\Stock\GetExportRequest;
use RakutenSDK\Request\Stock\GetListingRequest;
use RakutenSDK\Request\Stock\GetProductTypesRequest;
use RakutenSDK\Domain\Stock\Collection\ProductTypeCollection;
use RakutenSDK\Request\Stock\GetProductTypeTemplateRequest;

/**
 * @method ProductTypeCollection|Response getProductTypes(GetProductTypesRequest $request)
 * @method ProductTypeTemplate|Response getProductTypeTemplate(GetProductTypeTemplateRequest $request)
 * @method Import|Response sendGenericFile(SendGenericFileRequest $request)
 * @method Report|Response getGenericReport(GetGenericReportRequest $request)
 * @method ShippingTypes|Response getShippingTypes(GetShippingTypesRequest $request)
 * @method Export|Response getExport(GetExportRequest $request)
 * @method Listing|Response getListing(GetListingRequest $request)
 * @method Category|Response getCategories(GetCategoriesRequest $request)
 * @method SaleCollection|Response getNewSales(GetNewSalesRequest $request)
 */
class Client extends AbstractApiClient
{
    protected array $url = [
        'production' => 'https://ws.fr.shopping.rakuten.com',
        'sandbox' => 'https://sandbox.fr.shopping.rakuten.com'
    ];

    protected string $token;
    protected string $account;
    protected bool $sandbox;

    public function __construct(string $account, string $token, bool $sandbox = false)
    {
        $this->setAccount($account);
        $this->setToken($token);
        $this->setSandbox($sandbox);
        $this->queryParams = [
            'login' => $this->getAccount(),
            'pwd' => $this->getToken()
        ];
    }

    /**
     * @return  \GuzzleHttp\Client
     */
    protected function getDefaultClient(): GuzzleClient
    {
        $stack = HandlerStack::create();
        $stack->push(Middleware::history($this->history));

        $logger = $this->getLogger();
        if (!empty($logger)) {
            $stack->push(Middleware::log($logger, $this->getMessageFormatter()));
        }

        return new GuzzleClient([
            'handler' => $stack,
            'base_uri' => rtrim($this->getBaseUrl(), '/') . '/',
            'headers' => [
                'User-Agent' => $this->getUserAgent() ?: static::getDefaultUserAgent(),
                'Accept' => 'application/xml',
            ],
        ]);
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token): static
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $account
     * @return $this
     */
    public function setAccount(string $account): static
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->account;
    }

    /**
     * @param bool $sandbox
     * @return $this
     */
    public function setSandbox(bool $sandbox): static
    {
        $this->sandbox = $sandbox;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSandbox(): bool
    {
        return $this->sandbox;
    }

    public function getBaseUrl(): string
    {
        if (!isset($this->baseUrl)) {
            if ($this->getSandbox()) {
                $this->baseUrl = $this->url['sandbox'];
            } else {
                $this->baseUrl = $this->url['production'];
            }
        }
        return $this->baseUrl;
    }
}
