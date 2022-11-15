<?php
namespace RakutenSDK\Core\Response\Decorator;

use Psr\Http\Message\ResponseInterface;

/**
 * @method setNextPageToken(mixed $next_page_token)
 * @method setPreviousPageToken(mixed $previous_page_token)
 * @method setCollection(mixed $param)
 */
class SeekableCollection extends BaseCollection
{
    /**
     * @var string
     */
    protected string $previousPageToken;

    /**
     * @var string
     */
    protected string $nextPageToken;

    /**
     * @inheritdoc
     */
    public function decorate(ResponseInterface $response): SeekableCollection
    {
        $data = (new AssocArray())->decorate($response);

        $result = new SeekableCollection();

        if ($this->key) {
            $result->setCollection(new $this->class($data[$this->key]));
        }

        if (isset($data['previous_page_token'])) {
            $result->setPreviousPageToken($data['previous_page_token']);
        }

        if (isset($data['next_page_token'])) {
            $result->setNextPageToken($data['next_page_token']);
        }

        return $result;
    }
}
