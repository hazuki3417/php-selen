<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str;

use Selen\Verify\Str\Radixes\Radix;

class Alphabet
{
    /**
     * アルファベットの文字数.
     */
    public const NUMBER = 26;

    /**
     * アルファベット大文字の開始位置（ASCIIコード）.
     */
    public const UPPER_CASE_ASCII_CODE = 65;

    /**
     * アルファベット小文字の開始位置（ASCIIコード）.
     */
    public const LOWER_CASE_ASCII_CODE = 97;

    /**
     * 26進数指定でアルファベット（小文字）を取得するメソッド（a-z:0-p）.
     */
    public static function getLowerCase26Ary(string $val): string
    {
        if (!Radix::verify($val, self::NUMBER)) {
            throw new \InvalidArgumentException(
                'Please specify in 26-ary format.'
            );
        }

        $asciiCodeDiff = base_convert($val, self::NUMBER, 10);

        if (!self::isValidDiffAsciiCode((int) $asciiCodeDiff)) {
            throw new \RuntimeException(
                'Specify the value within the range of 1 digit of the 26-ary number.'
            );
        }

        /** @phpstan-ignore-next-line */
        $asciiCode = self::LOWER_CASE_ASCII_CODE + $asciiCodeDiff;

        return chr($asciiCode);
    }

    /**
     * 26進数指定でアルファベット（大文字）を取得するメソッド（a-z:0-p）.
     */
    public static function getUpperCase26Ary(string $val): string
    {
        if (!Radix::verify($val, self::NUMBER)) {
            throw new \InvalidArgumentException(
                'Please specify in 26-ary format.'
            );
        }

        $asciiCodeDiff = base_convert($val, self::NUMBER, 10);

        if (!self::isValidDiffAsciiCode((int) $asciiCodeDiff)) {
            throw new \RuntimeException(
                'Specify the value within the range of 1 digit of the 26-ary number.'
            );
        }

        /** @phpstan-ignore-next-line */
        $asciiCode = self::UPPER_CASE_ASCII_CODE + $asciiCodeDiff;

        return chr($asciiCode);
    }

    private static function isValidDiffAsciiCode(int $val): bool
    {
        $alphaNumRangeMin = 0;
        $alphaNumRangeMax = self::NUMBER;

        return $alphaNumRangeMin <= $val && $val < $alphaNumRangeMax;
    }
}
