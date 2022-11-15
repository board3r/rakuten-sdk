<?php
namespace RakutenSDK\Core\Response\Decorator;

trait FileTrait
{
    /**
     * @inheritdoc
     */
    public function getResponseDecorator(): File
    {
        return new File();
    }
}
