<?php
namespace RakutenSDK\Core\Domain;

interface ArrayableInterface
{
    /**
     * Give the value for an empty object
     *
     * @return mixed
     */
    public function getEmptyValue():mixed;

    /**
     * Check if current object is empty
     *
     * @return  bool
     */
    public function isEmpty(): bool;

    /**
     * Converts object to array
     *
     * @return  array
     */
    public function toArray(): array;

}
