<?php

namespace RakutenSDK\Domain\Import;

use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Core\Domain\LastVersionTrait;
use RakutenSDK\Domain\Import\Collection\ReportProductCollection;

/**
 * @method  string  getNextPageToken()
 * @method  int getTotalResultCount()
 * @method  ReportFile  getFile()
 * @method  ReportProductCollection getProducts()
 */
class Report extends BaseObject
{
    use LastVersionTrait;

    public static array $mapping = [
        'totalresultcount' => 'TotalResultCount',
        'nexttoken' => 'next_page_token',
        'product' => 'products'
    ];

    protected static array $dataTypes = [
        'file' => [ReportFile::class, 'create'],
        'products' => [ReportProductCollection::class, 'create'],
    ];
}
