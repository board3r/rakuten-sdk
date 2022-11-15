<?php
namespace RakutenSDK\Core\Request;

trait SeekableTrait
{
    /**
     * Limit from 10 (default) to 100 (max)
     *
     * @var int
     */
    protected int $limit;

    /**
     * Indicate whether or not this API should return the page associated to this token.
     * Please note that all other parameters are ignored when this token is present in request.
     *
     * @var bool
     */
    protected bool $pageToken;

    /**
     * @return  int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return  bool
     */
    public function getPageToken(): bool
    {
        return $this->pageToken;
    }

    /**
     * @param int $limit
     * @return  $this
     */
    public function setLimit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param string $pageToken
     * @return  $this
     */
    public function setPageToken(string $pageToken): static
    {
        $this->pageToken = $pageToken;

        return $this;
    }
}
