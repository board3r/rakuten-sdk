<?php

namespace RakutenSDK\Request\Import;

use JetBrains\PhpStorm\Pure;
use RakutenSDK\Core\Request\AbstractRequest;
use RakutenSDK\Core\Response\Decorator\BaseObject;
use RakutenSDK\Domain\Import\Import;
use RakutenSDK\Domain\Import\Report;
use RakutenSDK\Request\RakutenInterface;
use RakutenSDK\Request\RakutenTrait;

/**
 * @method string getPurgeAndReplace()
 * @method SendGenericFileRequest setPurgeAndReplace(bool $purge)
 */
class GetGenericReportRequest extends AbstractRequest implements RakutenInterface
{
    use RakutenTrait;

    public array $queryParams = [ 'fileid','nexttoken'];

    protected string $endpoint = '/stock_ws';

    /**
     * @param $reportID
     * @param string|null $nextPage
     */
    public function __construct($reportID, ?string $nextPage = null)
    {
        $this->setData('action', 'genericimportreport');
        $this->setVersion(['2017-02-10', '2011-11-29']);
        $data=[
            'fileid'=>$reportID,
            'nexttoken'=>$nextPage
        ];
        parent::__construct($data);
    }

    /**
     * @return \RakutenSDK\Core\Response\Decorator\BaseObject|\RakutenSDK\Domain\Import\Import
     */
    #[Pure]
    public function getResponseDecorator(): BaseObject|Import
    {
        return Report::decorator('response');
    }
}
