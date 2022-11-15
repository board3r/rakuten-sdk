<?php

namespace RakutenSDK\Domain\Import;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Domain\Import\Collection\ReportErrorCollection;

/**
 * @method  string  getSku()
 * @method  string  getStatus()
 * @method  string  getPid()
 * @method  string  getAid()
 * @method  bool hasErrors()
 * @method  ReportErrorCollection getErrors()
 */
class ReportProduct extends BaseObject
{

    protected static array $dataTypes = [
        'errors' => [ReportErrorCollection::class, 'create']
    ];

    public function __construct(array $data = [])
    {
        // if no errors exist, unset value
        if (isset($data['errors']) && !$data['errors']){
            unset($data['errors']);
        }else{
            // if multiple errors, the return comme with a wrapper array, need to remove it
            if ($arrayErrors = current($data['errors'])){
                if (!array_key_exists('error_code',$arrayErrors)){
                    $data['errors'] = $arrayErrors;
                }
            }
        }
        parent::__construct($data);
    }



}
