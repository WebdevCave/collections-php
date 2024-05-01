<?php

namespace WebdevCave\Collections;

use Countable;
use Generator;

interface LazyCollectionInterface extends Countable
{
    public function __construct(Generator $traversable);
    public static function from(Generator $generator): static;
    public function isEmpty(): bool;
    public function toArray(): array;
}
