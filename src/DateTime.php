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
     * 日付が未来かどうか確認します
     *
     * @return bool 未来の場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isFeature(): bool
    {
        return \time() < $this->record->toDateTime()->getTimestamp();
    }

    /**
     * 日付が過去かどうか確認します
     *
     * @return bool 過去の場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isPast(): bool
    {
        return $this->record->toDateTime()->getTimestamp() < \time();
    }

    /**
     * 自身の日付情報と入力の日付情報が同じか確認します
     *
     * @return bool 同じ場合はtrueを、それ以外の場合はfalseを返します
     */
    public function eq(\DateTime|DateTime $dateTime): bool
    {
        $selfDateTime  = $this->record->toDateTime();
        $inputDateTime = $this->extractInstance($dateTime);
        return $selfDateTime->getTimestamp() === $inputDateTime->getTimestamp();
    }

    /**
     * 自身の日付情報と入力の日付情報が異なるか確認します
     *
     * @return bool 異なる場合はtrueを、それ以外の場合はfalseを返します
     */
    public function ne(\DateTime|DateTime $dateTime): bool
    {
        $selfDateTime  = $this->record->toDateTime();
        $inputDateTime = $this->extractInstance($dateTime);
        return $selfDateTime->getTimestamp() !== $inputDateTime->getTimestamp();
    }

    /**
     * 自身の日付が入力日付より大きい確認します（$this > $dateTime）
     *
     * @return bool 大きい場合はtrueを、それ以外の場合はfalseを返します
     */
    public function gt(\DateTime|DateTime $dateTime): bool
    {
        $selfDateTime  = $this->record->toDateTime();
        $inputDateTime = $this->extractInstance($dateTime);
        return $selfDateTime->getTimestamp() > $inputDateTime->getTimestamp();
    }

    /**
     * 自身の日付が入力日付以上か確認します（$this >= $dateTime）
     *
     * @return bool 以上の場合はtrueを、それ以外の場合はfalseを返します
     */
    public function ge(\DateTime|DateTime $dateTime): bool
    {
        $selfDateTime  = $this->record->toDateTime();
        $inputDateTime = $this->extractInstance($dateTime);
        return $selfDateTime->getTimestamp() >= $inputDateTime->getTimestamp();
    }

    /**
     * 自身の日付が入力日付以下か確認します（$this <= $dateTime）
     *
     * @return bool 以下の場合はtrueを、それ以外の場合はfalseを返します
     */
    public function le(\DateTime|DateTime $dateTime): bool
    {
        $selfDateTime  = $this->record->toDateTime();
        $inputDateTime = $this->extractInstance($dateTime);
        return $selfDateTime->getTimestamp() <= $inputDateTime->getTimestamp();
    }

    /**
     * 自身の日付が入力日付より小さいか確認します（$this < $dateTime）
     *
     * @return bool 小さい場合はtrueを、それ以外の場合はfalseを返します
     */
    public function lt(\DateTime|DateTime $dateTime): bool
    {
        $selfDateTime  = $this->record->toDateTime();
        $inputDateTime = $this->extractInstance($dateTime);
        return $selfDateTime->getTimestamp() < $inputDateTime->getTimestamp();
    }
    /**
     * 日付文字列からインスタンスを生成します
     *
     * @param string $parseFormat パース文字列
     * @param string $dateTime 日付文字列
     *
     * @return \Selen\DateTime 成功した場合はインスタンスを返します
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
     * @return \Selen\DateTime 成功した場合はインスタンスを返します
     */
    public static function parseInt(int $timestamp): DateTime
    {
        $format   = 'Y-m-d H:i:s';
        $dateTime = \date($format, $timestamp);
        return new DateTime(Record::parseStr($format, $dateTime));
    }

    private function extractInstance(\DateTime|DateTime $dateTime): \DateTime
    {
        if ($dateTime instanceof DateTime) {
            return $dateTime->record->toDateTime();
        }
        return $dateTime;
    }
}
