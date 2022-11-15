<?php

namespace RakutenSDK\Request\Stock;

use JetBrains\PhpStorm\Pure;
use RakutenSDK\Core\Request\AbstractRequest;
use RakutenSDK\Core\Response\Decorator\BaseObject;
use RakutenSDK\Domain\Stock\Export;
use RakutenSDK\Request\RakutenInterface;
use RakutenSDK\Request\RakutenTrait;

class GetExportRequest extends AbstractRequest implements RakutenInterface
{
    use RakutenTrait;

    const  SCOPE_PRICING = 'PRICING';

    public array $queryParams = [ 'scope', 'nexttoken'];

    protected string $endpoint = '/stock_ws';

    public function __construct($withPricing = false, ?string $nextPage = null)
    {
        $this->setData('action', 'export');
        $this->setVersion(['2018-06-29', '2017-07-03', '2014-11-04', '2014-01-28', '2012-10-23', '2011-02-17']);
        $data = [
            'scope' => ($withPricing ? GetExportRequest::SCOPE_PRICING : null),
            'nexttoken' => $nextPage
        ];
        parent::__construct($data);
    }

    /**
     * @return \RakutenSDK\Core\Response\Decorator\BaseObject|\RakutenSDK\Domain\Stock\Export
     */
    #[Pure]
    public function getResponseDecorator(): BaseObject|Export
    {
        return Export::decorator('response');
    }
}
