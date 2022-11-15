<?php
namespace RakutenSDK\Core\Request;

trait PageableTrait
{
    /**
     * @var int
     */
    protected int $max = 10;

    /**
     * @var int
     */
    protected int $offset = 0;

    /**
     * Indicate whether or not this API should return paginated results
     *
     * @var bool
     */
    protected bool $paginate = true;

    /**
     * @return  int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * @return  int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return  bool
     */
    public function getPaginate(): bool
    {
        return $this->paginate;
    }

    /**
     * @param int $max
     * @return  $this
     */
    public function setMax(int $max): static
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @param int $offset
     * @return  $this
     */
    public function setOffset(int $offset): static
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @param bool $flag
     * @return  $this
     */
    public function setPaginate(bool $flag): static
    {
        $this->paginate = $flag;

        return $this;
    }
}
