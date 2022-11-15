<?php
namespace RakutenSDK\Core\Request;

use RakutenSDK\Core\Client\ApiClientInterface;

interface RequestInterface
{
    /**
     * Get request options parameters
     *
     * @return  array
     */
    public function getOptions(): array;

    /**
     * Get request body parameters
     *
     * @return  array
     */
    public function getBodyParams(): array;

    /**
     * Get request query parameters that should be duplicated
     *
     * @return  array
     */
    public function getDuplicatedQueryParams(): array;

    /**
     * HTTP method (GET, POST, PUT, PATCH, DELETE)
     *
     * @return  string
     */
    public function getMethod(): string;

    /**
     * Get request query parameters
     *
     * @return  array
     */
    public function getQueryParams(): array;

    /**
     * Get request URI
     *
     * @return  string
     */
    public function getUri(): string;

    /**
     * Returns true if query parameters can be duplicated if multiple values are specified, false otherwise.
     * For example if true:
     * order_id=ORD-123&order_id=ORD-456
     * instead of:
     * order_id[]=ORD-123&order_id[]=ORD-456
     *
     * @return  bool
     */
    public function haveQueryParamsDuplicated(): bool;

    /**
     * Returns whether the request body is JSON or not
     *
     * @return  bool
     */
    public function isJSON(): bool;

    /**
     * Executes request against provided API client
     *
     * @param   ApiClientInterface  $api
     * @return  mixed
     */
    public function run(ApiClientInterface $api): mixed;
}
