<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str\Radixes;

use LogicException;

class Radix
{
    /**
     * 基数かどうか判定します.
     *
     * @param string $num チェックする値
     * @param int $base チェックする基数
     *
     * @throws LogicException サポートしていない基数を指定したときに発生します
     *
     * @return bool 基数の場合はtrueを、それ以外の場合はfalseを返します
     */
    public static function verify(string $num, int $base): bool
    {
        switch ($base) {
            case Radix2::CARDINALITY:
                return Radix2::verify($num);
            case Radix3::CARDINALITY:
                return Radix3::verify($num);
            case Radix4::CARDINALITY:
                return Radix4::verify($num);
            case Radix5::CARDINALITY:
                return Radix5::verify($num);
            case Radix6::CARDINALITY:
                return Radix6::verify($num);
            case Radix7::CARDINALITY:
                return Radix7::verify($num);
            case Radix8::CARDINALITY:
                return Radix8::verify($num);
            case Radix9::CARDINALITY:
                return Radix9::verify($num);
            case Radix10::CARDINALITY:
                return Radix10::verify($num);
            case Radix16::CARDINALITY:
                return Radix16::verify($num);
            case Radix26::CARDINALITY:
                return Radix26::verify($num);
            default:
                break;
        }

        throw new LogicException(
            'Does not support validation of the specified radix'
        );
    }
}
