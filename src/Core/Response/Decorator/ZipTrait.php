<?php
namespace RakutenSDK\Core\Response\Decorator;

trait ZipTrait
{
    /**
     * @inheritdoc
     */
    public function getResponseDecorator(): File
    {
        return new File('zip');
    }
}
