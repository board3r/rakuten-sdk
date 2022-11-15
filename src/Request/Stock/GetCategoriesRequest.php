<?php

namespace RakutenSDK\Request\Stock;

use JetBrains\PhpStorm\Pure;
use RakutenSDK\Core\Request\AbstractRequest;
use RakutenSDK\Core\Response\Decorator\BaseObject;
use RakutenSDK\Domain\Stock\Category;
use RakutenSDK\Request\RakutenInterface;
use RakutenSDK\Request\RakutenTrait;

class GetCategoriesRequest extends AbstractRequest implements RakutenInterface
{
    use RakutenTrait;

    protected string $endpoint = '/categorymap_ws';

    public function __construct()
    {
        $this->setData('action', 'categorymap');
        $this->setVersion(['2011-10-11']);
        parent::__construct();
    }

    /**
     * @return \RakutenSDK\Core\Response\Decorator\BaseObject|\RakutenSDK\Domain\Stock\Export
     */
    #[Pure]
    public function getResponseDecorator(): BaseObject|Category
    {
        return Category::decorator('response.categories');
    }

}
