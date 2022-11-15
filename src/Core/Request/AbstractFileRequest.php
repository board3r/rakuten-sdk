<?php
namespace RakutenSDK\Core\Request;

use RakutenSDK\Core\Domain\FileTrait;
use RakutenSDK\Core\Domain\FileWrapper;
use SimpleXMLElement;
use SplFileObject;

abstract class AbstractFileRequest extends AbstractRequest
{
    use FileTrait;

    /**
     * @var string
     */
    protected string $method = 'POST';

    /**
     * @var bool
     */
    protected bool $json = false;

    /**
     * @param string|array|\SimpleXMLElement|\SplFileObject $file
     */
    public function __construct(string|array|SimpleXMLElement|SplFileObject $file)
    {
        parent::__construct();
        $this->setFile($file);
    }

    /**
     * @inheritdoc
     */
    public function getBodyParams(): array
    {
        $params = parent::getBodyParams();
        if ($this->file) {
            $params['file'] = (new FileWrapper($this->file))
                ->setFileName($this->getFileName());
        }

        return $params;
    }
}
