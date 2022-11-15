<?php

namespace RakutenSDK\Request\Import;

use RakutenSDK\Core\Request\AbstractFileRequest;
use JetBrains\PhpStorm\Pure;
use RakutenSDK\Core\Response\Decorator\BaseObject;
use RakutenSDK\Domain\Import\Import;
use RakutenSDK\Request\RakutenInterface;
use RakutenSDK\Request\RakutenTrait;
use SimpleXMLElement;
use SplFileObject;

/**
 * @method string getPurgeAndReplace()
 * @method SendGenericFileRequest setPurgeAndReplace(bool $purge)
 */
class SendGenericFileRequest extends AbstractFileRequest implements RakutenInterface
{
    use RakutenTrait;

    public array $queryParams = [ 'purgeandreplace'];

    protected string $endpoint = '/stock_ws';

    /**
     * @param string|array|\SimpleXMLElement|\SplFileObject $file
     * @param bool $purge
     */
    public function __construct(string|array|SimpleXMLElement|SplFileObject $file, bool $purge = false)
    {
        $this->setData('action', 'genericimportfile');
        $this->setVersion(['2015-02-02', '2012-09-11', '2011-11-29']);
        $this->setData('purgeandreplace', $purge);
        parent::__construct(parent::__construct($file));
        $this->setContentType('text/xml');
    }

    /**
     * @return \RakutenSDK\Core\Response\Decorator\BaseObject|\RakutenSDK\Domain\Import\Import
     */
    #[Pure]
    public function getResponseDecorator(): BaseObject|Import
    {
        return Import::decorator('response');
    }
}
