<?php

namespace RakutenSDK\Domain\Stock;

use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method null|string getBarcode()
 */
class ListingProductReference extends BaseObject
{
    /**
     * @return array|null
     */
    public function getAvalaible(): ?array
    {
        return $this->getData();
    }
}
