<?php

namespace RakutenSDK\Domain\Import;

use Cake\I18n\FrozenTime;
use RakutenSDK\Core\Domain\BaseObject;
use RakutenSDK\Domain\Import\Collection\ReportImageErrorListCollection;

/**
 * @method  string  getFilename()
 * @method  string  geStatus()
 * @method  FrozenTime  getUploadDate()
 * @method  FrozenTime  getProcessDate()
 * @method  int  getTotalLines()
 * @method  int  getProcessedLines()
 * @method  int  getErrorLines()
 * @method  string  getSuccessRate()
 * @method  string  getImageProcessStatus()
 * @method  bool  hasImageErrorList()
 * @method  ReportImageErrorListCollection  getImageErrorList()
 */
class ReportFile extends BaseObject
{
    public static array $mapping = [
        'totallines' => 'total_lines',
        'processedlines' => 'processed_lines',
        'errorlines' => 'error_lines',
        'successrate' => 'success_rate',
        'imageprocessstatus' => 'image_process_status',
        'uploaddate' => 'upload_date',
        'processdate' => 'process_date',
        'imageerrorlist' => 'image_error_list',
    ];
    protected static array $dataTypes = [
        'total_lines' => 'intval',
        'processed_lines' => 'intval',
        'error_lines' => 'intval',
        'image_error_list' => [ReportImageErrorListCollection::class, 'create'],
    ];
}
