<?php
namespace RakutenSDK\Core\Domain\Collection;

use RakutenSDK\Core\Domain\FileWrapper;

/**
 * @method  FileWrapper current()
 * @method  FileWrapper first()
 * @method  FileWrapper get($offset)
 * @method  FileWrapper offsetGet($offset)
 * @method  FileWrapper last()
 */
class FileCollection extends BaseCollection
{
    /**
     * @var ?string
     */
    protected ?string $itemClass = FileWrapper::class;
}
