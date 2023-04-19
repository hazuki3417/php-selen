<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Bool;

class Util
{
    /**
     * bool型を真偽値文字列に変換します
     *
     * @param bool $value 真偽値を渡します
     *
     * @return string 変換した値を返します
     */
    public static function toString(bool $value): string
    {
        return $value ? 'true' : 'false';
    }

    /**
     * trueが1つだけ存在するか確認します
     *
     * @return bool 1つだけ存在する場合はtrueを、それ以外の場合はfalseを返します
     *
     * @param bool[] $values
     */
    public static function oneTrue(bool ...$values): bool
    {
        $count = 0;

        foreach ($values as $result) {
            if ($result === true) {
                ++$count;
            }
        }
        return $count === 1;
    }

    /**
     * falseが1つだけ存在するか確認します
     *
     * @return bool 1つだけ存在する場合はtrueを、それ以外の場合はfalseを返します
     *
     * @param bool[] $values
     */
    public static function oneFalse(bool ...$values): bool
    {
        $count = 0;

        foreach ($values as $result) {
            if ($result === false) {
                ++$count;
            }
        }
        return $count === 1;
    }

    /**
     * trueが存在するか確認します
     *
     * @return bool 存在する場合はtrueを、それ以外の場合はfalseを返します
     *
     * @param bool[] $values
     */
    public static function anyTrue(bool ...$values): bool
    {
        foreach ($values as $result) {
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    /**
     * falseが存在するか確認します
     *
     * @return bool 存在する場合はtrueを、それ以外の場合はfalseを返します
     *
     * @param bool[] $values
     */
    public static function anyFalse(bool ...$values): bool
    {
        foreach ($values as $result) {
            if ($result === false) {
                return true;
            }
        }
        return false;
    }

    /**
     * すべてtrueか確認します
     *
     * @return bool すべてtrueの場合はtrueを、それ以外の場合はfalseを返します
     *
     * @param bool[] $values
     */
    public static function allTrue(bool ...$values): bool
    {
        $count = 0;

        foreach ($values as $result) {
            if ($result === true) {
                ++$count;
            }
        }
        return $count === count($values);
    }

    /**
     * すべてfalseか確認します
     *
     * @return bool すべてfalseの場合はtrueを、それ以外の場合はfalseを返します
     *
     * @param bool[] $values
     */
    public static function allFalse(bool ...$values): bool
    {
        $count = 0;

        foreach ($values as $result) {
            if ($result === false) {
                ++$count;
            }
        }
        return $count === count($values);
    }
}
