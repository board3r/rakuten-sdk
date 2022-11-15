<?php
namespace RakutenSDK\Core\Domain;

use SplFileObject;

class FileWrapper
{
    use DownloadableTrait;

    /**
     * string = file contents
     * array = CSV data
     *
     * @param array|string|\SplFileObject $file
     */
    public function __construct(array|string|SplFileObject $file)
    {
        $this->setFile($file);
    }
}
