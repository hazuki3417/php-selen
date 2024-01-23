<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\Str;

use ValueError;

class Util
{
    /**
     * 真偽値文字列をbool型に変換します
     *
     * @param string $value 真偽値文字列を渡します
     *
     * @return bool 変換した値を返します
     *
     * @throws ValueError 真偽値文字列が不正なときに発生します
     */
    public static function toBool(string $value): bool
    {
        $allowType = ['true', 'false'];

        if (!\in_array($value, $allowType, true)) {
            throw new ValueError("Invalid value. Expected value 'true' or 'false'");
        }
        return $value === 'true';
    }
}
