<?php
namespace RakutenSDK\Core\Domain\Collection;

use RakutenSDK\Core\Domain\Document;

/**
 * @method  Document    current()
 * @method  Document    first()
 * @method  Document    get($offset)
 * @method  Document    offsetGet($offset)
 * @method  Document    last()
 */
class DocumentCollection extends FileCollection
{
    /**
     * @var ?string
     */
    protected ?string $itemClass = Document::class;
}
