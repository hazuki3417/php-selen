<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str\Radixes;

interface RadixInterface
{
    /**
     * 基数かどうか判定します.
     *
     * @param string $val チェックする値
     *
     * @return bool 基数の場合はtrueを、それ以外の場合はfalseを返します
     */
    public static function verify(string $val): bool;
}
