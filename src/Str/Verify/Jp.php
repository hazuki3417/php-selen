<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Verify;

class Jp
{

    /**
     * ひらがなかどうか確認します。（Unicode範囲：U+3041~U+3096）
     *
     * @return bool ひらがなの場合はtrueを、それ以外の場合はfalseを返します
     *
     * @see https://www.unicode.org/charts/PDF/U3040.pdf
     */
    public static function isHiragana(string $str)
    {
        $range   = 'ぁ-ゖ';
        $pattern = \sprintf('/[%s]/u', $range);

        return 0 < preg_match($pattern, $str);
    }

    /**
     * カタカナかどうか確認します。（Unicode範囲：U+30A1~U+30FA）
     *
     * @return bool カタカナの場合はtrueを、それ以外の場合はfalseを返します
     *
     * @see https://www.unicode.org/charts/PDF/U30A0.pdf
     */
    public static function isKatakana(string $str)
    {
        $range   = 'ァ-ヺ';
        $pattern = \sprintf('/[%s]/u', $range);

        return 0 < preg_match($pattern, $str);
    }
}
