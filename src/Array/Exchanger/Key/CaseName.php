<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\Array\Exchanger\Key;

use Selen\Str\Exchanger\CaseName as ExchangerCaseName;

/**
 * ケースフォールディングを行うクラス（配列要素名）
 */
class CaseName
{
    /**
     * 配列要素文字をケバブケースに変換します
     *
     * @param array $values 変換する配列を渡します
     *
     * @return array 変換後の配列を返します
     */
    public static function kebab(array $values): array
    {
        $callback = function ($key) {
            return ExchangerCaseName::kebab($key);
        };
        return self::routine($values, $callback);
    }

    /**
     * 配列要素文字をスネークケースに変換します
     *
     * @param array $values 変換する配列を渡します
     *
     * @return array 変換後の配列を返します
     */
    public static function snake(array $values): array
    {
        $callback = function ($key) {
            return ExchangerCaseName::snake($key);
        };
        return self::routine($values, $callback);
    }

    /**
     * 配列要素文字をパスカルケースに変換します
     *
     * @param array $values 変換する配列を渡します
     *
     * @return array 変換後の配列を返します
     */
    public static function pascal(array $values): array
    {
        $callback = function ($key) {
            return ExchangerCaseName::pascal($key);
        };
        return self::routine($values, $callback);
    }

    /**
     * 配列要素文字をキャメルケースに変換します
     *
     * @param array $values 変換する配列を渡します
     *
     * @return array 変換後の配列を返します
     */
    public static function camel(array $values): array
    {
        $callback = function ($key) {
            return ExchangerCaseName::camel($key);
        };
        return self::routine($values, $callback);
    }

    /**
     * 配列要素文字をローワーケースに変換します
     *
     * @param array $values 変換する配列を渡します
     *
     * @return array 変換後の配列を返します
     */
    public static function lower(array $values): array
    {
        $callback = function ($key) {
            return ExchangerCaseName::lower($key);
        };
        return self::routine($values, $callback);
    }

    /**
     * 配列要素文字をアッパーケースに変換します
     *
     * @param array $values 変換する配列を渡します
     *
     * @return array 変換後の配列を返します
     */
    public static function upper(array $values): array
    {
        $callback = function ($key) {
            return ExchangerCaseName::upper($key);
        };
        return self::routine($values, $callback);
    }

    private static function routine(array $values, callable $callback): array
    {
        $tmpArr = [];

        foreach ($values as $originKey => $originValue) {
            $tmpValue = $originValue;

            if (\is_array($originValue)) {
                // 配列型なら再帰処理
                $tmpValue = self::routine($originValue, $callback);
            }

            if (\is_int($originKey)) {
                $tmpArr[$originKey] = $tmpValue;
                continue;
            }
            // keyがstring型のときの処理
            $renameKey          = $callback($originKey);
            $tmpArr[$renameKey] = $tmpValue;
        }
        return $tmpArr;
    }
}
