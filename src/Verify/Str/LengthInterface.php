<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str;

interface LengthInterface
{
    public function count(): int;

    public function gt(int $limen): bool;

    public function ge(int $limen): bool;

    public function le(int $limen): bool;

    public function lt(int $limen): bool;

    public function equal(int $size): bool;

    public function in(int $min, int $max): bool;

    public function out(int $min, int $max): bool;
}
