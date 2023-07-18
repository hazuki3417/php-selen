<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

class Enum
{
    public static function validate($value, string|int|float|bool|null ...$types): bool
    {
        if (\is_array($value)) {
            return false;
        }

        if (\is_object($value)) {
            return false;
        }

        return \in_array($value, $types, true);
    }
}
