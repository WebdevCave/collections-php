<?php

declare(strict_types=1);

namespace WebdevCave\Collections;

use Traversable;

class LazyCollection implements LazyCollectionInterface
{
    private Traversable $traversable;

    /**
     * @param Traversable|callable $traversable
     */
    public function __construct(Traversable|callable $traversable)
    {
        if (!($traversable instanceof Traversable)) {
            $traversable = $traversable();
        }

        $this->traversable = $traversable;
    }

    /**
     * @param Traversable|callable $generator
     * @return static
     */
    public static function from(Traversable|callable $generator): static
    {
        return new static($generator);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return iterator_to_array($this->traversable);
    }

    // interface Countable

    /**
     * @return int
     */
    public function count(): int
    {
        return iterator_count($this->traversable);
    }
}
