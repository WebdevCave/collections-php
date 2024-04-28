<?php

namespace WebdevCave\Collections;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Serializable;

interface CollectionInterface extends ArrayAccess, Countable, IteratorAggregate, JsonSerializable, Serializable
{
    public function __construct(array $data = []);
    public function &__get(string $name): mixed;
    public function __set(string $name, mixed $value): void;
    public function __isset(string $name): bool;
    public static function from(array|CollectionInterface $data): static;
    public function clear(): void;
    public function copy(): static;
    public function delete(string $index): void;
    public function get(string $index): mixed;
    public function has(string $index): bool;
    public function isEmpty(): bool;
    public function set(string $index, mixed $value): void;
    public function toArray(): array;
}
