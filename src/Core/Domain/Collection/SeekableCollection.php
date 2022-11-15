<?php
namespace RakutenSDK\Core\Domain\Collection;


class SeekableCollection
{
    /**
     * @var BaseCollection
     */
    protected BaseCollection $collection;

    /**
     * @var string|null
     */
    protected ?string $previousPageToken;

    /**
     * @var string|null
     */
    protected ?string $nextPageToken;

    /**
     * @return  BaseCollection
     */
    public function getCollection(): BaseCollection
    {
        return $this->collection;
    }

    /**
     * @param   BaseCollection    $collection
     * @return  $this
     */
    public function setCollection(BaseCollection $collection): static
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * @return  string|null
     */
    public function getPreviousPageToken(): ?string
    {
        return $this->previousPageToken;
    }

    /**
     * @param string|null $token
     * @return  $this
     */
    public function setPreviousPageToken(?string $token): static
    {
        $this->previousPageToken = $token;

        return $this;
    }

    /**
     * @return  string|null
     */
    public function getNextPageToken(): ?string
    {
        return $this->nextPageToken;
    }

    /**
     * @param string|null $token
     * @return  $this
     */
    public function setNextPageToken(?string $token): static
    {
        $this->nextPageToken = $token;

        return $this;
    }
}
