<?php
namespace RakutenSDK\Core\Domain;


trait DateFieldsTrait
{
    /**
     * The following fields will be converted to DateTime object if specified as string
     *
     * @var array
     */
    protected static array $dateFields = ['update_date','upload_date','process_date'];
}
