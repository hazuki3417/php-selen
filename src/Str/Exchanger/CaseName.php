<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Exchanger;

/**
 * ケースフォールディングを行うクラス
 */
class CaseName
{
    /**
     * ケバブケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換後の文字列を返します
     */
    public static function kebab(string $value): string
    {
        $delimiter = '-';
        $tmp       = self::trim(self::addCamelCaseDelimiter($value));
        return self::lower(self::replaceDelimiter($delimiter, $tmp));
    }

    /**
     * スネークケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換後の文字列を返します
     */
    public static function snake(string $value): string
    {
        $delimiter = '_';
        $tmp       = self::trim(self::addCamelCaseDelimiter($value));
        return self::lower(self::replaceDelimiter($delimiter, $tmp));
    }

    /**
     * パスカルケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換後の文字列を返します
     */
    public static function pascal(string $value): string
    {
        $delimiter = ' ';
        $tmp       = self::trim(self::addCamelCaseDelimiter($value));
        $str       = \ucwords(self::replaceDelimiter($delimiter, $tmp));
        return \ucfirst(\preg_replace('/[ ]+/', '', $str));
    }

    /**
     * キャメルケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換後の文字列を返します
     */
    public static function camel(string $value): string
    {
        $delimiter = ' ';
        $tmp       = self::trim(self::addCamelCaseDelimiter($value));
        $str       = \ucwords(self::replaceDelimiter($delimiter, $tmp));
        return \lcfirst(\preg_replace('/[ ]+/', '', $str));
    }

    /**
     * ローワーケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換後の文字列を返します
     */
    public static function lower(string $value): string
    {
        return \mb_strtolower($value);
    }

    /**
     * アッパーケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換後の文字列を返します
     */
    public static function upper(string $value): string
    {
        return \mb_strtoupper($value);
    }

    /**
     * 文字列の前後にある特定の文字（' ', '_', '-'）をトリムします
     *
     * @param string $value トリムする文字列を渡します
     *
     * @return string トリム後の文字列を返します
     */
    private static function trim(string $value): string
    {
        return trim($value, ' _-');
    }

    /**
     * 文字列内にある特定の文字（' ', '_', '-'）を置換します
     *
     * @param string $delimiter デリミタ文字を指定します
     * @param string $value     置換対象の文字列を渡します
     *
     * @return string 置換後の文字列を返します
     */
    private static function replaceDelimiter(string $delimiter, string $value): string
    {
        return \preg_replace('/[-|_| ]+/', $delimiter, $value);
    }

    /**
     * キャメルケースに該当する文字の先頭に区切り文字（' '）を追加します
     *
     * @param string $value 文字列を渡します
     *
     * @return string 文字列を返します
     */
    private static function addCamelCaseDelimiter(string $value): string
    {
        $delimiter  = ' ';
        $replaceStr = \sprintf('%s${1}', $delimiter);
        return preg_replace('/([A-Z])/', $replaceStr, $value);
    }
}
