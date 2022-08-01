<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str;

/**
 * ケースフォールディングを行うクラス
 */
class CaseName
{
    public static function kebab(string $value): string
    {
        $delimiter = '-';
        $tmp = self::trim(self::addCamelCaseDelimiter($value));
        return self::lower(self::replaceDelimiter($delimiter, $tmp));
    }

    public static function snake(string $value): string
    {
        $delimiter = '_';
        $tmp = self::trim(self::addCamelCaseDelimiter($value));
        return self::lower(self::replaceDelimiter($delimiter, $tmp));
    }

    public static function pascal(string $value): string
    {
        $delimiter = ' ';
        $tmp = self::trim(self::addCamelCaseDelimiter($value));
        $str = \ucwords(self::replaceDelimiter($delimiter, $tmp));
        return \ucfirst(\preg_replace('/[ ]+/', '', $str));
    }

    public static function camel(string $value): string
    {
        $delimiter = ' ';
        $tmp = self::trim(self::addCamelCaseDelimiter($value));
        $str = \ucwords(self::replaceDelimiter($delimiter, $tmp));
        return \lcfirst(\preg_replace('/[ ]+/', '', $str));
    }

    public static function lower(string $value): string
    {
        return \mb_strtolower($value);
    }

    public static function upper(string $value): string
    {
        return \mb_strtoupper($value);
    }

    private static function trim(string $value): string
    {
        return trim($value, ' _-');
    }

    private static function replaceDelimiter(string $delimiter, string $value): string
    {
        return \preg_replace('/[-|_| ]+/', $delimiter, $value);
    }

    /**
     * キャメルケースに該当する文字の先頭に区切り文字（half space）を追加します
     */
    private static function addCamelCaseDelimiter(string $value): string
    {
        $delimiter = ' ';
        $replaceStr = \sprintf('%s${1}', $delimiter);
        return preg_replace('/([A-Z])/', $replaceStr, $value);
    }
}
