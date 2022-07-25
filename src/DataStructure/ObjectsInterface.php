<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\DataStructure;

interface ObjectsInterface
{
    public function isEmpty(): bool;

    public function isNotEmpty(): bool;

    public function size(): int;

    public function clear();
}
