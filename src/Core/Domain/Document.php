<?php
namespace RakutenSDK\Core\Domain;

use SplFileObject;

/**
 * @method  string  getDocumentName()
 * @method  $this   setDocumentName(string $documentName)
 * @method  string  getDocumentType()
 * @method  $this   setDocumentType(string $documentType)
 */
class Document extends FileWrapper
{
    use DataObjectTrait;

    /**
     * @param string|array|\SplFileObject $file
     * @param string $documentName
     * @param string $documentType
     */
    public function __construct(string|array|SplFileObject $file, string $documentName, string $documentType)
    {
        parent::__construct($file);
        $this->setDocumentName($documentName);
        $this->setDocumentType($documentType);
    }
}
