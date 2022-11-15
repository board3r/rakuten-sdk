<?php
namespace RakutenSDK\Core\Response\Decorator;

use RakutenSDK\Core\Domain\FileWrapper;
use RakutenSDK\Core\Response\ResponseDecoratorInterface;
use RakutenSDK\Core\Utility\Functions;
use Psr\Http\Message\ResponseInterface;

class File implements ResponseDecoratorInterface
{
    /**
     * @var string
     */
    protected string $extension;

    /**
     * @param string $extension
     */
    public function __construct(string $extension = 'txt')
    {
        $this->setExtension($extension);
    }

    /**
     * @inheritdoc
     */
    public function decorate(ResponseInterface $response): FileWrapper
    {
        return Functions::parseFileResponse($response, $this->extension);
    }

    /**
     * @return  string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return  $this
     */
    public function setExtension(string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }
}
