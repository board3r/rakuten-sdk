<?php

namespace RakutenSDK\Request\Stock;

use JetBrains\PhpStorm\Pure;
use RakutenSDK\Core\Request\AbstractRequest;
use RakutenSDK\Core\Response\Decorator\BaseObject;
use RakutenSDK\Domain\Stock\ProductTypeTemplate;
use RakutenSDK\Request\RakutenInterface;
use RakutenSDK\Request\RakutenTrait;

/**
 * @method string getAlias()
 * @method string getScope()
 * @method GetProductTypeTemplateRequest setAlias(string $alias)
 * @method GetProductTypeTemplateRequest setScope(?string $scope)
 */
class GetProductTypeTemplateRequest extends AbstractRequest implements RakutenInterface
{
    use RakutenTrait;

    const SCOPE_VALUES = 'VALUES';

    public array $queryParams = [ 'alias', 'scope'];

    protected string $endpoint = '/stock_ws';

    /**
     * @param string $productType
     * @param bool $withValues
     */
    public function __construct(string $productType, bool $withValues = false)
    {
        $this->setData('action', 'producttypetemplate');
        $this->setVersion(['2017-10-04', '2015-02-02', '2013-05-14', '2012-09-11', '2011-11-29']);
        $data = [
            'alias' => $productType,
            'scope' => $withValues ? GetProductTypeTemplateRequest::SCOPE_VALUES : null,
        ];
        parent::__construct($data);
    }

    /**
     * @return \RakutenSDK\Core\Response\Decorator\BaseObject|\RakutenSDK\Domain\Stock\ProductTypeTemplate
     */
    #[Pure]
    public function getResponseDecorator(): ProductTypeTemplate|BaseObject
    {
        return ProductTypeTemplate::decorator('response');
    }

}
