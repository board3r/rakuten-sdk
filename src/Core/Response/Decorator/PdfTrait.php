<?php
namespace RakutenSDK\Core\Response\Decorator;

trait PdfTrait
{
    /**
     * @inheritdoc
     */
    public function getResponseDecorator(): File
    {
        return new File('pdf');
    }
}
