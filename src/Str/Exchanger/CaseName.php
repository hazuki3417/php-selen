<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Exchanger;

/**
 * ケースフォールディングを提供するクラスです
 */
class CaseName
{
    /**
     * 文字列をケバブケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換した文字列を返します
     */
    public static function kebab(string $value): string
    {
        $delimiter = '-';
        $tmp       = self::trim(self::addCamelCaseDelimiter($value));
        return self::lower(self::replaceDelimiter($delimiter, $tmp));
    }

    /**
     * 文字列をスネークケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換した文字列を返します
     */
    public static function snake(string $value): string
    {
        $delimiter = '_';
        $tmp       = self::trim(self::addCamelCaseDelimiter($value));
        return self::lower(self::replaceDelimiter($delimiter, $tmp));
    }

    /**
     * 文字列をパスカルケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換した文字列を返します
     */
    public static function pascal(string $value): string
    {
        $delimiter = ' ';
        $tmp       = self::trim(self::addCamelCaseDelimiter($value));
        $str       = \ucwords(self::replaceDelimiter($delimiter, $tmp));
        return \ucfirst(\preg_replace('/[ ]+/', '', $str));
    }

    /**
     * 文字列をキャメルケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換した文字列を返します
     */
    public static function camel(string $value): string
    {
        $delimiter = ' ';
        $tmp       = self::trim(self::addCamelCaseDelimiter($value));
        $str       = \ucwords(self::replaceDelimiter($delimiter, $tmp));
        return \lcfirst(\preg_replace('/[ ]+/', '', $str));
    }

    /**
     * 文字列をローワーケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換した文字列を返します
     */
    public static function lower(string $value): string
    {
        return \mb_strtolower($value);
    }

    /**
     * 文字列をアッパーケースに変換します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換した文字列を返します
     */
    public static function upper(string $value): string
    {
        return \mb_strtoupper($value);
    }

    /**
     * 文字列の前後にある特定の文字（' ', '_', '-'）をトリムします
     *
     * @param string $value 文字列を渡します
     *
     * @return string トリムした文字列を返します
     */
    private static function trim(string $value): string
    {
        return trim($value, ' _-');
    }

    /**
     * 文字列内にある特定の文字（' ', '_', '-'）を置換します
     *
     * @param string $delimiter 区切り文字を渡します
     * @param string $value     変換する文字列を渡します
     *
     * @return string 変換した文字列を返します
     */
    private static function replaceDelimiter(string $delimiter, string $value): string
    {
        return \preg_replace('/[-|_| ]+/', $delimiter, $value);
    }

    /**
     * キャメルケースに該当する文字の先頭に区切り文字（' '）を追加します
     *
     * @param string $value 変換する文字列を渡します
     *
     * @return string 変換した文字列を返します
     */
    private static function addCamelCaseDelimiter(string $value): string
    {
        $delimiter  = ' ';
        $replaceStr = \sprintf('%s${1}', $delimiter);
        return preg_replace('/([A-Z])/', $replaceStr, $value);
    }
}
