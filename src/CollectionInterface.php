<?php

namespace WebdevCave\Collections;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Serializable;

interface CollectionInterface extends ArrayAccess, Countable, IteratorAggregate, JsonSerializable, CollectionHelpersInterface
{
    public static function from(array|CollectionInterface $data): static;
    public function append(mixed $value): void;
    public function clear(): void;
    public function copy(): static;
    public function delete(string $index): void;
    public function get(string $index): mixed;
    public function has(string $index): bool;
    public function isEmpty(): bool;
    public function lazy(): LazyCollection;
    public function set(string $index, mixed $value): void;
}
