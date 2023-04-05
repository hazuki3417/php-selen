<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Bool;

class Util
{
    public static function toString(bool $results)
    {
        return $results ? 'true' : 'false';
    }

    public static function oneTrue(bool ...$results): bool
    {
        $count = 0;

        foreach ($results as $result) {
            if ($result === true) {
                ++$count;
            }
        }
        return $count === 1;
    }

    public static function oneFalse(bool ...$results): bool
    {
        $count = 0;

        foreach ($results as $result) {
            if ($result === false) {
                ++$count;
            }
        }
        return $count === 1;
    }

    public static function anyTrue(bool ...$results): bool
    {
        foreach ($results as $result) {
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    public static function anyFalse(bool ...$results): bool
    {
        foreach ($results as $result) {
            if ($result === false) {
                return true;
            }
        }
        return false;
    }

    public static function allTrue(bool ...$results): bool
    {
        $count = 0;

        foreach ($results as $result) {
            if ($result === true) {
                ++$count;
            }
        }
        return $count === count($results);
    }

    public static function allFalse(bool ...$results): bool
    {
        $count = 0;

        foreach ($results as $result) {
            if ($result === false) {
                ++$count;
            }
        }
        return $count === count($results);
    }
}
