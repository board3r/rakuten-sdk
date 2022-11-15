<?php
namespace RakutenSDK\Core\Request;

use RakutenSDK\Core\Client\ApiClientInterface;
use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Core\Exception\RequestValidationException;
use RakutenSDK\Core\Response\Decorator;
use RakutenSDK\Core\Utility\Functions;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;

/**
 * @method string    getAction()
 * @method string    getVersion()
 */

abstract class AbstractRequest extends BaseObject implements RequestInterface
{
    /**
     * HTTP method (GET, POST, PUT, ...)
     *
     * @var string
     */
    protected string $method = 'GET';

    /**
     * @var string
     */
    protected string $endpoint = '/';

    /**
     * If true, request body will be encoded into JSON format
     *
     * @var bool
     */
    protected bool $json = true;

    /**
     * Request URI variables as an associative array
     *
     * Pattern:
     * [ '{uri_variable}' => 'data_key' ]
     *
     * Concrete example:
     * [ '{offer}' => 'offer_id' ]
     *
     * @var array
     */
    protected array $uriVars = [];

    /**
     * @var array
     */
    protected array $duplicatedQueryParams = [];

    /**
     * Array of query string parameters
     *
     * @var array
     */
    public array $queryParams = [];

    /**
     * Array of request body parameters
     *
     * @var array
     */
    public array $bodyParams = [];

    /**
     * Special parameters that can be 'true', 'false' or 'all'
     *
     * @var array
     */
    public array $boolOrAllParams = [];

    /**
     * Request options
     *
     * @var array
     */
    protected array $options = ['headers' => ['Accept' => 'application/json']];


    /**
     * @return  bool
     */
    public function haveQueryParamsDuplicated(): bool
    {
        return !empty($this->duplicatedQueryParams);
    }

    /**
     * @param   array   $params
     * @return  array
     */
    protected function buildParams(array $params): array
    {
        if (empty($params)) {
            return [];
        }

        $mapping = [];
        foreach ($params as $key => $value) {
            $mapping[is_int($key) ? $value : $key] = $value;
        }
        $params = array_intersect_key($this->toArray(), $mapping);
        return Functions::arrayMapKeys($params, $mapping);
    }

    /**
     * Verify that all required URI vars are present
     *
     * @return  void
     * @throws  RequestValidationException
     */
    protected function validateRequiredUriVars()
    {
        $diff = array_diff($this->uriVars, array_keys($this->data));
        if (!empty($diff)) {
            throw new RequestValidationException(
                sprintf('%s requires the following information: %s', __CLASS__, implode(', ', $this->uriVars))
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function getBodyParams(): array
    {
        return $this->buildParams($this->bodyParams);
    }

    /**
     * Get request query parameters that should be duplicated
     *
     * @return  array
     */
    public function getDuplicatedQueryParams(): array
    {
        return $this->duplicatedQueryParams;
    }

    /**
     * Returns the request endpoint to access an API
     *
     * @return  string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Returns the HTTP method used for current request
     *
     * @return  string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams(): array
    {
        $params = $this->buildParams($this->queryParams);
        // Handle special boolean or ALL parameters
        foreach ($this->boolOrAllParams as $param) {
            $value = $this->getData($param);
            $params[$param] = (null !== $value) ?
                ($value ? 'true' : 'false') :
                'all';
        }

        /** @see RakutenTrait */
        if ($this->getAction()) {
            $params['action'] = $this->getAction();
        }
        if ($this->getVersion()) {
            $params['version'] = $this->getVersion();
        }

        /**
         * Format boolean values as strings
         */
        array_walk($params, function(&$val) {
            if (is_bool($val)) {
                $val = $val ? 'true' : 'false';
            }
        });
        return $params;
    }

    /**
     * @inheritdoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Overrides all request options by specified ones
     *
     * @param   array   $options
     * @return  $this
     */
    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Removes a specific option by key
     *
     * @param string $key
     * @return  $this
     */
    public function removeOption(string $key): static
    {
        if (isset($this->options[$key])) {
            unset($this->options[$key]);
        }

        return $this;
    }

    /**
     * Add a request option
     *
     * @param string $key
     * @param   mixed   $value
     * @return  $this
     */
    public function addOption(string $key, mixed $value): static
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    #[Pure]
    public function getResponseDecorator()
    {
        return new Decorator\Closure(function (ResponseInterface $response) {

            $contentType =  $response->getHeaderLine('Content-Type');
            if (str_starts_with($contentType, 'application/json') || str_starts_with($contentType, 'application/xml') || str_starts_with($contentType, 'text/xml')) {
                return new Decorator\AssocArray(); // default is to transform JSON or XML responses to associative array
            }
            return $response;
        });
    }

    /**
     * @inheritdoc
     * @throws \RakutenSDK\Core\Exception\RequestValidationException
     */
    public function getUri(): string
    {
        $this->validateRequiredUriVars();

        $vars = array_map(function($var) {
            return $this->getData($var);
        }, $this->uriVars);

        $uri = strtr($this->getEndpoint(), $vars);

        return trim($uri, '/');
    }

    /**
     * @inheritdoc
     */
    public function isJSON(): bool
    {
        return $this->json;
    }

    /**
     * @inheritdoc
     */
    public function run(ApiClientInterface $api): mixed
    {
        return $this->getResponseDecorator()->decorate($api->run($this));
    }
}
