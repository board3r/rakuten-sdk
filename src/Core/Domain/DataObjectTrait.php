<?php
namespace RakutenSDK\Core\Domain;

use Cake\I18n\FrozenTime;
use Cake\Utility\Inflector;
use RakutenSDK\Core\Utility\Functions;
use InvalidArgumentException;
use JetBrains\PhpStorm\Pure;
use stdClass;

trait DataObjectTrait
{
    /**
     * Object attributes
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Set/Get attribute wrapper
     *
     * @param string $method
     * @param array $args
     * @return  mixed
     */
    public function __call(string $method, array $args)
    {
        $key = Inflector::delimit(substr($method, 3));
        switch (strtolower(substr($method, 0, 3))) {
            case 'get':
                return $this->getData($key);
            case 'set':
                return $this->setData($key, $args[0] ?? null);
            case 'uns':
                return $this->unsetData($key);
            case 'has':
                return $this->hasData($key);
        }

        // Handle boolean check on keys
        if (str_starts_with($method, 'is')) {
            return (bool) $this->getData(Inflector::delimit(substr($method, 2)));
        }

        throw new InvalidArgumentException(
            sprintf('Invalid method %s::%s(%s)', get_class($this), $method, print_r($args, true))
        );
    }

    /**
     * Proxy to toJSON() method
     *
     * @return  string
     */
    public function __toString()
    {
        return $this->toJSON();
    }

    /**
     * Useful method to create object quickly
     *
     * @param   array   $data
     * @return  $this
     */
    public static function create(array $data = []): static
    {
        return (new static)->setData($data);
    }

    /**
     * Get value from data array
     *
     * @param mixed|null $key
     * @return  mixed
     */
    public function getData(mixed $key = null): mixed
    {
        if (null === $key) {
            return $this->data;
        }

        if (is_array($key)) {
            $data = [];
            foreach ($key as $k) {
                if (isset($this->data[$k])) {
                    $data[$k] = $this->data[$k];
                }
            }

            return $data;
        }

        return $this->data[$key] ?? null;
    }

    /**
     * Give the value for an empty object
     *
     * @return  \stdClass
     */
    #[Pure]
    public function getEmptyValue(): stdClass
    {
        return new stdClass();
    }

    /**
     * Checks if current object has a value for the given key
     *
     * @param string $key
     * @return  bool
     */
    public function hasData(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Check if current object is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Overwrite data in the object
     *
     * The $key parameter can be string or array
     * If $key is a string, the attribute value will be overwritten by $value
     *
     * If $key is an array, it will overwrite all the data in the object
     *
     * @param array|string $key
     * @param mixed|null $value
     * @return  $this
     */
    public function setData(array|string $key, mixed $value = null): static
    {
        if (is_array($key)) {
            $this->data = $key;
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Converts object data to array
     *
     * @return  array
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->data as $key => $value) {
            if (is_float($value)) {
                $value = sprintf('%.5F', $value);
            } elseif ($value instanceof FrozenTime) {
                $value = Functions::dateFormat($value);
            } elseif ($value instanceof ArrayableInterface) {
                if ($value->isEmpty()) {
                    $value = $value->getEmptyValue();
                } else {
                    $value = $value->toArray();
                }
            }
            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * Converts object data to JSON
     *
     * @return  string
     */
    public function toJSON(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Unset data from the object
     *
     * @param array|string|null $key
     * @return  $this
     */
    public function unsetData(array|string $key = null): static
    {
        if ($key === null) {
            $this->data = [];
        } elseif (is_string($key)) {
            unset($this->data[$key]);
        } elseif (is_array($key)) {
            foreach ($key as $k) {
                $this->unsetData($k);
            }
        }

        return $this;
    }

    /**
     * Loop through current object data and apply a callback function on each value
     *
     * @param   callable    $callback
     * @param   array       $keys
     * @param   array       $args
     * @param bool $notNull
     * @return  array
     */
    public function walk(callable $callback, array $keys = [], array $args = [], bool $notNull = true): array
    {
        $result = [];
        foreach ($this->getData($keys) as $key => $value) {
            if (!$notNull || null !== $value) {
                $result[$key] = call_user_func_array($callback, array_merge([$value], $args));
            }
        }

        return $result;
    }
}
