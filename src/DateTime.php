<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen;

use Selen\DateTime\Record;

/**
 * 日付に関する処理を提供するクラス
 */
class DateTime
{
    public Record $record;
    public function __construct(Record $dateTimeRecord)
    {
        $this->record = $dateTimeRecord;
    }

    /**
     * 日付文字列からインスタンスを生成します
     *
     * @param string $parseFormat パース文字列
     * @param string $dateTime    日付文字列
     *
     * @return DateTime 成功した場合はインスタンスを返します
     */
    public static function parseStr(string $parseFormat, string $dateTime): DateTime
    {
        return new DateTime(Record::parseStr($parseFormat, $dateTime));
    }

    /**
     * タイムスタンプからインスタンスを生成します
     *
     * @param int $timestamp タイムスタンプ
     *
     * @return DateTime 成功した場合はインスタンスを返します
     */
    public static function parseInt(int $timestamp): DateTime
    {
        $format   = 'Y-m-d H:i:s';
        $dateTime = \date($format, $timestamp);
        return new DateTime(Record::parseStr($format, $dateTime));
    }
}
