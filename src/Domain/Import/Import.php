<?php

namespace RakutenSDK\Domain\Import;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Core\Domain\LastVersionTrait;

/**
 * @method  string  getImportId()
 * @method  string  getStatus()
 */
class Import extends BaseObject
{
    use LastVersionTrait;

    public static array $mapping = [
        'importid' => 'import_id'
    ];
}
