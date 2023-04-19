<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\DateTime;

use DateTimeInterface;

/**
 * \DateTimeクラスに関するUtilを提供するクラス
 */
class Util
{
    private \DateTimeInterface $dateTime;

    public function __construct(DateTimeInterface $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * 日付が未来かどうか確認します
     *
     * @return bool 未来の場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isFeature(): bool
    {
        return \time() < $this->dateTime->getTimestamp();
    }

    /**
     * 日付が過去かどうか確認します
     *
     * @return bool 過去の場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isPast(): bool
    {
        return $this->dateTime->getTimestamp() < \time();
    }

    /**
     * 自身の日付情報と入力の日付情報が同じか確認します
     *
     * @param \DateTimeInterface $dateTime 比較対象の日付情報を渡します
     *
     * @return bool 同じ場合はtrueを、それ以外の場合はfalseを返します
     */
    public function eq(DateTimeInterface $dateTime): bool
    {
        return $this->dateTime->getTimestamp() === $dateTime->getTimestamp();
    }

    /**
     * 自身の日付情報と入力の日付情報が異なるか確認します
     *
     * @param \DateTimeInterface $dateTime 比較対象の日付情報を渡します
     *
     * @return bool 異なる場合はtrueを、それ以外の場合はfalseを返します
     */
    public function ne(DateTimeInterface $dateTime): bool
    {
        return $this->dateTime->getTimestamp() !== $dateTime->getTimestamp();
    }

    /**
     * 自身の日付が入力日付より大きい確認します（$this > $dateTime）
     *
     * @param \DateTimeInterface $dateTime 比較対象の日付情報を渡します
     *
     * @return bool 大きい場合はtrueを、それ以外の場合はfalseを返します
     */
    public function gt(DateTimeInterface $dateTime): bool
    {
        return $this->dateTime->getTimestamp() > $dateTime->getTimestamp();
    }

    /**
     * 自身の日付が入力日付以上か確認します（$this >= $dateTime）
     *
     * @param \DateTimeInterface $dateTime 比較対象の日付情報を渡します
     *
     * @return bool 以上の場合はtrueを、それ以外の場合はfalseを返します
     */
    public function ge(DateTimeInterface $dateTime): bool
    {
        return $this->dateTime->getTimestamp() >= $dateTime->getTimestamp();
    }

    /**
     * 自身の日付が入力日付以下か確認します（$this <= $dateTime）
     *
     * @param \DateTimeInterface $dateTime 比較対象の日付情報を渡します
     *
     * @return bool 以下の場合はtrueを、それ以外の場合はfalseを返します
     */
    public function le(DateTimeInterface $dateTime): bool
    {
        return $this->dateTime->getTimestamp() <= $dateTime->getTimestamp();
    }

    /**
     * 自身の日付が入力日付より小さいか確認します（$this < $dateTime）
     *
     * @param \DateTimeInterface $dateTime 比較対象の日付情報を渡します
     *
     * @return bool 小さい場合はtrueを、それ以外の場合はfalseを返します
     */
    public function lt(DateTimeInterface $dateTime): bool
    {
        return $this->dateTime->getTimestamp() < $dateTime->getTimestamp();
    }
}
