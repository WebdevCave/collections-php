<?php

declare(strict_types=1);

namespace WebdevCave\Collections;

use ArrayIterator;
use Traversable;


/**
 * Represents a collection of data with support for nested keys.
 *
 * This class provides methods to manipulate data stored in a hierarchical manner,
 * where keys can be nested using dot notation.
 *
 * Example usage:
 *
 * $collection = new Collection([
 *     'user' => [
 *         'name' => 'John Doe',
 *         'email' => 'john@example.com',
 *         'address' => [
 *             'city' => 'New York',
 *             'country' => 'USA'
 *         ]
 *     ]
 * ]);
 *
 * // Accessing nested data
 * $city = $collection->get('user.address.city'); // Returns 'New York'
 *
 * // Checking if a nested key exists
 * $hasCountry = $collection->has('user.address.country'); // Returns true
 *
 * // Setting a value for a nested key
 * $collection->set('user.address.postal_code', '10001');
 *
 * // Clearing the collection
 * $collection->clear();
 *
 * @author Your Name
 */
class Collection implements CollectionInterface
{
    /**
     * @param array $data
     */
    public function __construct(protected array $data = [])
    {
        // Does nothing
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function &__get(string $name): mixed
    {
        return $this->data[$name];
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * @param array|CollectionInterface $data
     * @return static
     */
    public static function from(array|CollectionInterface $data): static
    {
        return new static($data instanceof CollectionInterface ? $data->toArray() : $data);
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->data = [];
    }

    /**
     * @return $this
     */
    public function copy(): static
    {
        return new static($this->data);
    }

    /**
     * @param string $index
     * @return void
     */
    public function delete(string $index): void
    {
        $keys = explode('.', $index);
        $data = &$this->data;

        // Percorre cada nível da chave
        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!isset($data[$key]) || !is_array($data[$key])) {
                return; // A chave não existe, não há necessidade de continuar
            }

            $data = &$data[$key];
        }

        // Remove o último elemento da chave
        unset($data[array_shift($keys)]);
    }

    /**
     * @param string $index
     * @return mixed
     */
    public function get(string $index): mixed
    {
        $layer = &$this->data;

        foreach (explode('.', $index) as $key) {
            if (!isset($layer[$key])) {
                return null;
            }

            $layer = &$layer[$key];
        }

        return $layer;
    }

    /**
     * @param string $index
     * @return bool
     */
    public function has(string $index): bool
    {
        $layer = &$this->data;

        foreach (explode('.', $index) as $key) {
            if (!isset($layer[$key])) {
                return false;
            }

            $layer = &$layer[$key];
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * @param string $index
     * @param mixed $value
     * @return void
     */
    public function set(string $index, mixed $value): void
    {
        $layer = &$this->data;

        foreach (explode('.', $index) as $key) {
            if (!isset($layer[$key]) || !is_array($layer[$key])) {
                $layer[$key] = [];
            }

            $layer = &$layer[$key];
        }

        $layer = $value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    // interface ArrayAccess

    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    /**
     * @param $offset
     * @param $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * @param $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    // interface Countable

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }

    // interface IteratorAggregate

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }

    // interface JsonSerializable

    /**
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->data;
    }

    // interface Serializable

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize($this->data);
    }

    /**
     * @param string $data
     * @return void
     */
    public function unserialize(string $data): void
    {
        $this->data = unserialize($data);
    }
}
