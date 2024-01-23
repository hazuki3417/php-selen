<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Generator;

/**
 * ランダムな文字列の生成を提供するクラスです
 */
class Random
{
    /**
     * プールからランダムな1文字を生成します
     *
     * @param string $pool プールする文字列を指定します
     *
     * @return string 生成した文字列を返します
     */
    public static function char(string $pool): string
    {
        $index = mt_rand(0, strlen($pool) - 1);
        return \substr($pool, $index, 1);
    }

    /**
     * プールからランダムな文字列を生成します
     *
     * @param string $pool   プールする文字列を指定します
     * @param int    $length 文字列長を指定します
     *
     * @return string 生成した文字列を返します
     */
    public static function str(string $pool, int $length): string
    {
        $str = '';

        for ($i = 0; $i < $length; ++$i) {
            $str .= self::char($pool);
        }
        return $str;
    }

    /**
     * ランダムなアルファベット文字列を生成します
     *
     * @param int $length 文字列長を指定します
     *
     * @return string 生成した文字列を返します
     */
    public static function alpha(int $length): string
    {
        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return self::str($pool, $length);
    }

    /**
     * ランダムな数字文字列を生成します
     *
     * @param int $length 文字列長を指定します
     *
     * @return string 生成した文字列を返します
     */
    public static function num(int $length): string
    {
        $pool = '0123456789';
        return self::str($pool, $length);
    }

    /**
     * ランダムなアルファベット・数字文字列を生成します
     *
     * @param int $length 文字列長を指定します
     *
     * @return string 生成した文字列を返します
     */
    public static function alphaNum(int $length): string
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return self::str($pool, $length);
    }
}
