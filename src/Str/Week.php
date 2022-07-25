<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str;

/**
 * 日本語・英語の曜日を相互変換するクラス.
 */
class Week
{
    /**
     * NOTE: 相互変換フロー
     *       英語　 > 数値（weekId） > 日本語
     *       日本語 > 数値（weekId） > 英語.
     */
    public const EN_LONG_NAMES = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
    ];

    public const EN_SHORT_NAMES = [
        'Sun',
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat',
    ];

    public const JP_LONG_NAMES = [
        '日曜日',
        '月曜日',
        '火曜日',
        '水曜日',
        '木曜日',
        '金曜日',
        '土曜日',
    ];

    public const JP_SHORT_NAMES = [
        '日',
        '月',
        '火',
        '水',
        '木',
        '金',
        '土',
    ];

    /**
     * 曜日IDの妥当性を確認します.
     *
     * @return bool 有効な場合はtrueを、それ以外の場合はfalseを返します
     */
    public static function checkWeekId(int $weekId)
    {
        $startWeekId = 0;
        $endWeekId = 6;

        return $startWeekId <= $weekId && $weekId <= $endWeekId;
    }

    /**
     * 曜日文字列（en）を曜日IDに変換します.
     *
     * @return int 対応する曜日IDを返します。対応する曜日IDがない場合は-1を返します
     */
    public static function enWeekStrToWeekId(string $weekEnName)
    {
        $longId = array_search($weekEnName, self::EN_LONG_NAMES, true);

        if ($longId !== false) {
            return $longId;
        }

        $shortId = array_search($weekEnName, self::EN_SHORT_NAMES, true);

        if ($shortId !== false) {
            return $shortId;
        }

        return -1;
    }

    /**
     * 曜日文字列（jp）を曜日IDに変換します.
     *
     * @return int 対応する曜日IDを返します。対応する曜日IDがない場合は-1を返します
     */
    public static function jpWeekStrToWeekId(string $weekJpName)
    {
        $longId = array_search($weekJpName, self::JP_LONG_NAMES, true);

        if ($longId !== false) {
            return $longId;
        }

        $shortId = array_search($weekJpName, self::JP_SHORT_NAMES, true);

        if ($shortId !== false) {
            return $shortId;
        }

        return -1;
    }

    /**
     * 英語から日本語に変換します.
     *
     * @return string
     *
     * @param mixed $week
     */
    public static function toJp($week, string $format)
    {
        $isInteger = is_int($week);
        $isString = is_string($week);
        $allowArgWeekType = $isInteger || $isString;

        if (!$allowArgWeekType) {
            throw new \InvalidArgumentException('型が不正');
        }

        $weekId = 0;

        if ($isInteger) {
            if (!self::checkWeekId($week)) {
                throw new \InvalidArgumentException('値が不正');
            }
            $weekId = $week;
        }

        if ($isString) {
            $weekId = self::enWeekStrToWeekId($week);

            if ($weekId < 0) {
                throw new \InvalidArgumentException('値が不正');
            }
        }

        switch (true) {
            case $format === 'l':
                return self::JP_LONG_NAMES[$weekId];
            case $format === 'D':
                return self::JP_SHORT_NAMES[$weekId];
            default:
                break;
        }

        throw new \InvalidArgumentException('値が不正');
    }

    /**
     * 日本語から英語に変換します.
     *
     * @return string
     *
     * @param mixed $week
     */
    public static function toEn($week, string $format)
    {
        $isInteger = is_int($week);
        $isString = is_string($week);
        $allowArgWeekType = $isInteger || $isString;

        if (!$allowArgWeekType) {
            throw new \InvalidArgumentException('型が不正');
        }

        $weekId = 0;

        if ($isInteger) {
            if (!self::checkWeekId($week)) {
                throw new \InvalidArgumentException('値が不正');
            }
            $weekId = $week;
        }

        if ($isString) {
            $weekId = self::jpWeekStrToWeekId($week);

            if ($weekId < 0) {
                throw new \InvalidArgumentException('値が不正');
            }
        }

        switch (true) {
            case $format === 'l':
                return self::EN_LONG_NAMES[$weekId];
            case $format === 'D':
                return self::EN_SHORT_NAMES[$weekId];
            default:
                break;
        }

        throw new \InvalidArgumentException('値が不正');
    }
}
