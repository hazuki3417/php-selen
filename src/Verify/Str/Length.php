<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str;

use LogicException;

class Length implements LengthInterface
{
    private $str;

    private function __construct(string $val)
    {
        $this->str = $val;
    }

    public static function set(string $val): Length
    {
        return new self($val);
    }

    /**
     * 文字の長さを取得します.
     *
     * @return int 文字の長さを返します
     */
    public function count(): int
    {
        return \mb_strlen($this->str);
    }

    /**
     * 文字数がしきい値より大きいか判定します.
     *
     * @param int $limen 検査する文字数のしきい値を指定します
     *
     * @throws LogicException しきい値に負数を指定した場合に発生します
     *
     * @return bool 文字数がしきい値より大きい場合はtrue、小さい場合はfalseを返します
     */
    public function gt(int $limen): bool
    {
        $this->verifySignedInteger($limen);

        return $limen < $this->count();
    }

    /**
     * 文字数がしきい値以上か判定します.
     *
     * @param int $limen 検査する文字数のしきい値を指定します
     *
     * @throws LogicException しきい値に負数を指定した場合に発生します
     *
     * @return bool 文字数がしきい値以上の場合はtrue、小さい場合はfalseを返します
     */
    public function ge(int $limen): bool
    {
        $this->verifySignedInteger($limen);

        return $limen <= $this->count();
    }

    /**
     * 文字数がしきい値以下か判定します.
     *
     * @param int $limen 検査する文字数のしきい値を指定します
     *
     * @throws LogicException しきい値に負数を指定した場合に発生します
     *
     * @return bool 文字数がしきい値以下の場合はtrue、小さい場合はfalseを返します
     */
    public function le(int $limen): bool
    {
        $this->verifySignedInteger($limen);

        return $this->count() <= $limen;
    }

    /**
     * 文字数がしきい値より小さいか判定します.
     *
     * @param int $limen 検査する文字数のしきい値を指定します
     *
     * @throws LogicException しきい値に負数を指定した場合に発生します
     *
     * @return bool 文字数がしきい値より小さい場合はtrue、小さい場合はfalseを返します
     */
    public function lt(int $limen): bool
    {
        $this->verifySignedInteger($limen);

        return $this->count() < $limen;
    }

    /**
     * 文字数がしきい値と同じか判定します.
     *
     * @param int $limen 検査する文字数のしきい値を指定します
     *
     * @throws LogicException しきい値に負数を指定した場合に発生します
     *
     * @return bool 文字数がしきい値より小さい場合はtrue、小さい場合はfalseを返します
     */
    public function equal(int $size): bool
    {
        $this->verifySignedInteger($size);

        return $this->count() === $size;
    }

    /**
     * 文字数が指定範囲内か判定します（$min <= strLen <= $max）.
     *
     * @param int $min 検査する文字数の最小しきい値を指定します
     * @param int $max 検査する文字数の最大しきい値を指定します
     *
     * @throws LogicException しきい値に負数を指定した場合に発生します
     *
     * @return bool 文字数が指定範囲内の場合はtrue、指定範囲外の場合はfalseを返します
     */
    public function in(int $min, int $max): bool
    {
        $this->verifySignedInteger($min);
        $this->verifySignedInteger($max);
        $this->verifyMinAndMaxLimen($min, $max);

        return $min <= $this->count() && $this->count() <= $max;
    }

    /**
     * 文字数が指定範囲外か判定します（$min < strLen < $max）.
     *
     * @param int $min 検査する文字数の最小しきい値を指定します
     * @param int $max 検査する文字数の最大しきい値を指定します
     *
     * @throws LogicException しきい値に負数を指定した場合に発生します
     *
     * @return bool 文字数が指定範囲外の場合はtrue、指定範囲内の場合はfalseを返します
     */
    public function out(int $min, int $max): bool
    {
        $this->verifySignedInteger($min);
        $this->verifySignedInteger($max);
        $this->verifyMinAndMaxLimen($min, $max);

        return $this->count() < $min || $max < $this->count();
    }

    /**
     * 値が負数かどうか検証します.
     *
     * @param int $val 検証する値を渡します
     *
     * @throws LogicException 値が負数の場合に発生します
     */
    private function verifySignedInteger(int $val)
    {
        if ($val < 0) {
            throw new LogicException('Signed integers cannot be specified');
        }
    }

    /**
     * 最大値より大きい値を最小値に指定しているか検証します.
     *
     * @param int $min 検証する値を渡します
     * @param int $max 検証する値を渡します
     *
     * @throws LogicException 最大値より大きい値を最小値に指定している倍位に発生します
     */
    private function verifyMinAndMaxLimen(int $min, int $max)
    {
        if ($min > $max) {
            throw new LogicException('A value greater than max cannot be specified for min');
        }
    }
}
