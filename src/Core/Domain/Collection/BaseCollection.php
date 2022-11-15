<?php

namespace RakutenSDK\Core\Domain\Collection;

use RakutenSDK\Core\Domain\ArrayableInterface;
use RakutenSDK\Core\Response\Decorator;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JetBrains\PhpStorm\Pure;
use Traversable;

class BaseCollection implements ArrayableInterface, ArrayAccess, IteratorAggregate, Countable
{
    /**
     * Collection items
     *
     * @var array
     */
    protected array $items = [];

    /**
     * @var string|null
     */
    protected ?string $itemClass;

    /**
     * @var int|null
     */
    protected ?int $totalCount;

    /**
     * @param array $items
     * @param int|null $totalCount
     */
    public function __construct(array $items = [], ?int $totalCount = null)
    {
        $this->setItems($items);
        if (null !== $totalCount) {
            $this->setTotalCount($totalCount);
        }
    }

    /**
     * @param mixed $item
     * @return  $this
     */
    public function add(mixed $item): self
    {
        $this->items[] = !is_object($item) ? $this->newItem($item) : $item;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param array $items
     * @param int|null $totalCount
     * @return  $this
     */
    public static function create(array $items = [], ?int $totalCount = null): static
    {
        if (!isset($totalCount)){
            if($items){
                $totalCount = count($items);
            }else{
                $totalCount = 0;
            }
        }
        return new static($items, $totalCount);
    }

    /**
     * @return  mixed
     */
    public function current(): mixed
    {
        return current($this->items);
    }

    /**
     * Useful method for requests returning collections
     *
     * @param string|null $key
     * @return  Decorator\BaseCollection
     */
    #[Pure]
    public static function decorator(?string $key = null): Decorator\BaseCollection
    {
        return new Decorator\BaseCollection(static::class, $key);
    }

    /**
     * @param mixed $offset
     * @return  bool
     */
    public function exists(mixed $offset): bool
    {
        return $this->offsetExists($offset);
    }

    /**
     * @return  mixed
     */
    public function first(): mixed
    {
        return reset($this->items);
    }

    /**
     * @param   $offset
     * @return  mixed
     */
    public function get($offset): mixed
    {
        return $this->offsetGet($offset);
    }

    /**
     * @inheritdoc
     */
    public function getEmptyValue(): array
    {
        return [];
    }

    /**
     * @return  array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return  int|null
     */
    public function getTotalCount(): ?int
    {
        return $this->totalCount;
    }

    /**
     * @inheritdoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * @return  mixed
     */
    public function last(): mixed
    {
        return end($this->items);
    }

    /**
     * @return  mixed
     */
    public function next(): mixed
    {
        return next($this->items);
    }

    /**
     * @param array $item
     * @return  mixed
     */
    public function newItem(array $item): mixed
    {
        return strlen($this->itemClass) ? new $this->itemClass($item) : $item;
    }

    /**
     * @param mixed $offset
     * @return  bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function offsetSet(mixed $offset, $value): void
    {
        $this->items[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        if (isset($this->items[$offset])) {
            unset($this->items[$offset]);
        }
    }

    /**
     * @return  mixed
     */
    public function prev(): mixed
    {
        return prev($this->items);
    }

    /**
     * @param mixed $offset
     */
    public function remove(mixed $offset): void
    {
        $this->offsetUnset($offset);
    }

    /**
     * @return  $this
     */
    public function reset(): self
    {
        $this->items = [];

        return $this;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function set(mixed $key, mixed $value): void
    {
        $this->offsetSet($key, $value);
    }

    /**
     * @param string $class
     * @return  $this
     */
    public function setItemClass(string $class): self
    {
        $this->itemClass = $class;

        return $this;
    }

    /**
     * @param array $items
     * @return  $this
     */
    public function setItems(array $items): self
    {
        if ($this->itemClass) {
            array_walk($items, function (&$item) {
                if (is_array($item)) {
                    $item = $this->newItem($item);
                }
            });
        }

        $this->items = $items;

        return $this;
    }

    /**
     * @param int $totalCount
     * @return  $this
     */
    public function setTotalCount(int $totalCount): self
    {
        $this->totalCount = $totalCount;

        return $this;
    }

    /**
     * @return  array
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this as $item) {
            if ($item instanceof ArrayableInterface) {
                $item = $item->toArray();
            }
            $result[] = $item;
        }

        return $result;
    }

    /**
     * @param string $method
     * @param array $args
     * @return  array
     */
    public function walk(string $method, array $args = []): array
    {
        $result = [];
        foreach ($this as $item) {
            $result[] = call_user_func_array([$item, $method], $args);
        }

        return $result;
    }
}
