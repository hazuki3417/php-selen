<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

class ArrayType
{
    /**
     * 配列の要素値が指定された型かどうかを検証します
     *
     * @param array<mixed,mixed> $values   検証する値を指定します
     * @param string             $typeName 型名を指定します
     */
    public static function validate(array $values, string $typeName): bool
    {
        foreach ($values as $value) {
            if (!Type::validate($value, $typeName)) {
                return false;
            }
        }
        return true;
    }
}
