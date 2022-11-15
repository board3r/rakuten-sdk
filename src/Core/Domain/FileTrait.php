<?php
namespace RakutenSDK\Core\Domain;

use RakutenSDK\Core\Utility\Functions;
use SimpleXMLElement;
use SplFileObject;

trait FileTrait
{
    use MimeTypesTrait;

    /**
     * @var string
     */
    protected string $contentType = 'application/octet-stream';

    /**
     * @var \SplFileObject
     */
    protected SplFileObject $file;

    /**
     * @var string
     */
    protected string $fileName;

    /**
     * @var string
     */
    protected string $fileExtension;

    /**
     * @return  string|null
     */
    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    /**
     * @return  \SplFileObject
     */
    public function getFile(): SplFileObject
    {
        return $this->file;
    }

    /**
     * @return  string
     */
    public function getFileName(): string
    {
        return $this->fileName ?: $this->file->getFilename();
    }

    /**
     * @param string|null $contentType
     * @return  $this
     */
    public function setContentType(string $contentType = null): static
    {
        $this->contentType = $contentType ?: 'application/octet-stream';

        return $this;
    }

    /**
     * @param string|array|\SimpleXMLElement|\SplFileObject $file
     * @return $this
     */
    public function setFile(string|array|SimpleXMLElement|SplFileObject $file): static
    {
        $this->file = Functions::createFile($file);

        return $this;
    }

    /**
     * One of csv, json, xml, pdf, zip, ...
     * @param   string  $extension
     * @param bool $updateContentType
     * @return  $this
     *@see MimeTypesTrait::$mimeTypes
     *
     */
    public function setFileExtension(string $extension, bool $updateContentType = true): static
    {
        $this->fileExtension = isset(static::$mimeTypes[$extension]) ? $extension : null;

        if ($updateContentType) {
            $this->setContentType($this->fileExtension);
        }

        return $this;
    }

    /**
     * @param string $fileName
     * @return  $this
     */
    public function setFileName(string $fileName): static
    {
        $this->fileName = str_replace('"', '_', $fileName);

        return $this;
    }
}
