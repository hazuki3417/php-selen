<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str;

use InvalidArgumentException;

/**
 * string型で表現されたデータ量をint型へ変換するクラスです。
 */
class SizeParser
{
    /** @var string[] SI接頭辞 */
    public const UNIT_SI_PREFIX = ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB', 'RB', 'QB'];
    /** @var string[] 2進接頭辞 */
    public const UNIT_BINARY_PREFIX = ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB', 'RiB', 'QiB'];
    /** @var string[] その他の接頭辞 */
    public const UNIT_OTHER_PREFIX = ['byte'];

    /**
     * string型で表現されたデータ量をbyte単位に変換します
     *
     * @param string $value 文字列を渡します
     *
     * @return int|float byte数を返します
     */
    public static function toByte(string $value)
    {
        [
            'value' => $value,
            'unit'  => $tmpUnit,
        ]     = self::parse($value);
        $unit = \strtolower($tmpUnit);

        if ($unit === 'byte') {
            // byte指定のみ
            return $value;
        }

        $radix     = \strpos($unit, 'i') === false ? 1000 : 1024;
        $scanChars = ['k', 'm', 'g', 't', 'p', 'e', 'z', 'y', 'r', 'q'];

        foreach ($scanChars as $index => $scanChar) {
            if (\strpos($unit, $scanChar) === false) {
                continue;
            }
            return $value * pow($radix, ($index + 1));
        }
    }

    /**
     * string型で表現されたデータ量を値と単位に分割します
     *
     * @param string $value 文字列を渡します
     *
     * @return array 文字列表現されたデータ量を値と単位に分割した配列を返します
     */
    public static function parse(string $value): array
    {
        $pattern = '/^(\d+)([a-zA-Z]{1,4})$/';

        $allowUnitType = \array_merge(
            self::UNIT_SI_PREFIX,
            self::UNIT_BINARY_PREFIX,
            self::UNIT_OTHER_PREFIX,
        );

        if (preg_match($pattern, $value, $matches)) {
            [1 => $value,2 => $unit] = $matches;

            if (\in_array($unit, $allowUnitType)) {
                return [
                    'value' => (int) $value,
                    'unit'  => $unit,
                ];
            }
        }
        $format = 'Invalid data format. Specify an integer value for the value, and specify %s for the unit.';
        $mes    = \sprintf($format, \implode(', ', $allowUnitType));
        throw new InvalidArgumentException($mes);
    }
}
