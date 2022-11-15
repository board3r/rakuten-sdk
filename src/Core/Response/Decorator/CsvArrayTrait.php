<?php
namespace RakutenSDK\Core\Response\Decorator;

use JetBrains\PhpStorm\Pure;

trait CsvArrayTrait
{
    /**
     * @inheritdoc
     */
    #[Pure]
    public function getResponseDecorator(): CsvArray
    {
        return new CsvArray();
    }
}
