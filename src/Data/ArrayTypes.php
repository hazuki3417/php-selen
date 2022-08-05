<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

class ArrayTypes
{
    public static function validate(array $data, string ...$typeName): bool
    {
        foreach ($data as $value) {
            if (!Types::validate($value, ...$typeName)) {
                return false;
            }
        }
        return true;
    }
}
