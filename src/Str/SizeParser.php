<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
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

        $radix       = \strpos($unit, 'i') === false ? 1000 : 1024;
        $scanChars   = ['k', 'm', 'g', 't', 'p', 'e', 'z', 'y', 'r', 'q'];
        $selectIndex = 0;

        foreach ($scanChars as $index => $scanChar) {
            if (\strpos($unit, $scanChar) === false) {
                continue;
            }
            $selectIndex = $index + 1;
            break;
        }
        return $value * pow($radix, ($selectIndex));
    }

    /**
     * string型で表現されたデータ量を値と単位に分割します
     *
     * @param string $value 文字列を渡します
     *
     * @throws InvalidArgumentException パースに失敗したときの例外をスローします
     *
     * @return array<string,int|string> 文字列表現されたデータ量を値と単位に分割した配列を返します
     */
    public static function parse(string $value)
    {
        $pattern = self::makeRegexPattern();

        if (preg_match($pattern, $value, $matches)) {
            [1 => $value,2 => $unit] = $matches;

            return [
                'value' => (int) $value,
                'unit'  => $unit,
            ];
        }
        throw self::makeParseException();
    }

    /**
     * string型で表現されたデータ量フォーマットが正しいか検証します
     *
     * @param string $value 文字列を渡します
     *
     * @return bool 正しい場合はtrueを、それ以外の場合はfalseを返します
     */
    public static function validParse(string $value): bool
    {
        return \preg_match(self::makeRegexPattern(), $value);
    }

    /**
     * string型で表現されたデータ量フォーマットのパースに失敗したときの例外をスローします
     *
     * @return InvalidArgumentException パースに失敗したときの例外をスローします
     */
    public static function makeParseException()
    {
        $format = 'Invalid data format. Expected format %s .';
        $mes    = \sprintf($format, self::makeRegexPattern());
        return new InvalidArgumentException($mes);
    }

    /**
     * string型で表現されたデータ量フォーマットをパースする正規表現パターンを作成します
     *
     * @return string 正規表現パターンを返します
     */
    private static function makeRegexPattern(): string
    {
        $allowUnits = \array_merge(
            self::UNIT_SI_PREFIX,
            self::UNIT_BINARY_PREFIX,
            self::UNIT_OTHER_PREFIX,
        );
        return \sprintf('/^(\d+)(%s)$/', \implode('|', $allowUnits));
    }
}
