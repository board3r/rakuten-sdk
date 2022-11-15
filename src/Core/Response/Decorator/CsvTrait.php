<?php
namespace RakutenSDK\Core\Response\Decorator;

trait CsvTrait
{
    /**
     * @inheritdoc
     */
    public function getResponseDecorator(): File
    {
        return new File('csv');
    }
}
