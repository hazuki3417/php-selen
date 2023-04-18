<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\DateTime;

use DateTime;
use ValueError;

/**
 * 日付情報を保持するクラス
 */
class Record
{
    /** @var int 年 */
    public int $year;
    /** @var int 月 */
    public int $month;
    /** @var int 日 */
    public int $day;
    /** @var int 時 */
    public int $hour;
    /** @var int 分 */
    public int $minute;
    /** @var int 秒 */
    public int $second;

    /**
     * @param int $year 年
     * @param int $month 月
     * @param int $day 日
     * @param int $hour 時
     * @param int $minute 分
     * @param int $second 秒
     */
    public function __construct(
        int $year = 1,
        int $month = 1,
        int $day = 1,
        int $hour = 0,
        int $minute = 0,
        int $second = 0,
    ) {
        /**
         * NOTE: 無効な日付は許容しないように実装しています。
         *       下記のクラス・メソッドで日付文字列をパースした場合、値が変換されるケースがあります。
         *       例）月の最大日数より大きい日付を指定すると月をまたいだ値となる。
         *       new DateTimeImmutable('2001-02-35')
         *         -> 2001-03-07 として扱われる
         *       DateTime::createFromFormat('Y-m-d', '2001-02-35'))
         *         -> 2001-03-07 として扱われる
         *       下記の関数は日付文字列のパースのみを提供する。
         *       date_parse_from_format()
         */
        $mes          = 'Invalid value. Please specify a value of %s or more for $%s.';
        $this->year   = (1 <= $year) ? $year : throw new ValueError(\sprintf($mes, 1, 'year'));
        $this->month  = (1 <= $month) ? $month : throw new ValueError(\sprintf($mes, 1, 'month'));
        $this->day    = (1 <= $day) ? $day : throw new ValueError(\sprintf($mes, 1, 'day'));
        $this->hour   = (0 <= $hour) ? $hour : throw new ValueError(\sprintf($mes, 0, 'hour'));
        $this->minute = (0 <= $minute) ? $minute : throw new ValueError(\sprintf($mes, 0, 'minute'));
        $this->second = (0 <= $second) ? $second : throw new ValueError(\sprintf($mes, 0, 'second'));

        if (!\checkdate($this->month, $this->day, $this->year)) {
            throw new ValueError('Invalid Gregorian calendar.');
        }
    }

    /**
     * 日付文字列からインスタンスを生成します
     *
     * @param string $parseFormat パース文字列
     * @param string $dateTime 日付文字列
     *
     * @return \Selen\DateTime\Record 成功した場合はインスタンスを返します
     */
    public static function parseStr(string $parseFormat, string $dateTime): Record
    {
        if ($parseFormat === '') {
            throw new ValueError('Invalid value. Please specify format string.');
        }

        if ($dateTime === '') {
            throw new ValueError('Invalid value. Please specify a date string.');
        }

        /**
         * NOTE: 日付の妥当性チェックを行うために下記の関数を利用しています。
         *       - date_parse_from_format()
         *       理由）上記以外のクラス・メソッドで日付文字列をパースした場合、値が変換されるケースがあります。
         *
         *       例）月の最大日数より大きい日付を指定すると月をまたいだ値となる。
         *       new DateTimeImmutable('2001-02-35')
         *         -> 2001-03-07 として扱われる
         *       DateTime::createFromFormat('Y-m-d', '2001-02-35'))
         *         -> 2001-03-07 として扱われる
         */
        $result = date_parse_from_format($parseFormat, $dateTime);

        if (0 < $result['error_count']) {
            throw new ValueError('Failed to parse. Invalid date format or date string.');
        }

        return new self(
            $result['year']   === false ? 1 : $result['year'],
            $result['month']  === false ? 1 : $result['month'],
            $result['day']    === false ? 1 : $result['day'],
            $result['hour']   === false ? 0 : $result['hour'],
            $result['minute'] === false ? 0 : $result['minute'],
            $result['second'] === false ? 0 : $result['second'],
        );
    }

    /**
     * DateTimeインスタンスを取得します
     *
     * @return \DateTime インスタンスを返します
     */
    public function toDateTime(): DateTime
    {
        return (new DateTime())
            ->setDate($this->year, $this->month, $this->day)
            ->setTime($this->hour, $this->minute, $this->second);
    }
}
