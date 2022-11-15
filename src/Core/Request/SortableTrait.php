<?php
namespace RakutenSDK\Core\Request;

trait SortableTrait
{
    /**
     * @var string
     */
    protected string $sortBy;

    /**
     * @var string
     */
    protected string $dir;

    /**
     * @return  string
     */
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * @param string $dir
     * @return  $this
     */
    public function setDir(string $dir): static
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * @return  string
     */
    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    /**
     * @param string $sortBy
     * @return  $this
     */
    public function setSortBy(string $sortBy): static
    {
        $this->sortBy = $sortBy;

        return $this;
    }

    /**
     * @return  $this
     */
    public function sortAsc(): static
    {
        $this->dir = 'ASC';

        return $this;
    }

    /**
     * @return  $this
     */
    public function sortDesc(): static
    {
        $this->dir = 'DESC';

        return $this;
    }
}
