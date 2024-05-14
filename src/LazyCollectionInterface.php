<?php

namespace WebdevCave\Collections;

use Generator;

interface LazyCollectionInterface extends CollectionHelpersInterface
{
    public function __construct(Generator $traversable);
    public static function from(Generator $generator): static;
}
