<?php

namespace WebdevCave\Collections;

use Countable;

interface CollectionHelpersInterface extends Countable
{
    public function contains(mixed $value): bool;
    public function each(callable $callback): void;
    public function isEmpty(): bool;
    public function toArray(): array;
}