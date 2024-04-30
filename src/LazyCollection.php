<?php

namespace WebdevCave\Collections;

use Generator;
use WebdevCave\Collections\LazyCollectionInterface;

class LazyCollection implements LazyCollectionInterface
{
    /**
     * @param Generator $generator
     */
    public function __construct(private Generator $generator)
    {
        // Does nothing
    }

    /**
     * @param Generator $generator
     * @return static
     */
    public static function from(Generator $generator): static
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
        return iterator_to_array($this->generator);
    }

    // interface Countable


    /**
     * @return int
     */
    public function count(): int
    {
        return iterator_count($this->generator);
    }
}
