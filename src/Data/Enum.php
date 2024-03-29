<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

class Enum
{
    /**
     * 値が指定された型かどうかを検証します
     *
     * @param mixed                      $value 検証する値を指定します
     * @param string|int|float|bool|null $types Enumで管理する値を定義します
     */
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
