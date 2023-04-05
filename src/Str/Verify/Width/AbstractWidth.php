<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Verify\Width;

abstract class AbstractWidth
{
    /** @var int 半角1文字の幅 */
    public const HALF_CHARACTER_WIDTH = 1;

    /** @var int 全角1文字の幅 */
    public const FULL_CHARACTER_WIDTH = 2;

    /** @var string */
    protected $str;

    public function __construct(string $val)
    {
        $this->str = $val;
    }

    /**
     * すべて全角文字だった場合の横幅の長さを計算します
     *
     * @return int 横幅の長さを返します
     */
    protected function calcStrAllFullWidth(): int
    {
        return $this->getStrLength() * self::FULL_CHARACTER_WIDTH;
    }

    /**
     * すべて半角文字だった場合の横幅の長さを計算します
     *
     * @return int 横幅の長さを返します
     */
    protected function calcStrAllHalfWidth(): int
    {
        return $this->getStrLength() * self::HALF_CHARACTER_WIDTH;
    }

    /**
     * 文字列の長さを取得します
     *
     * @return int 文字列の長さを返します
     */
    protected function getStrLength(): int
    {
        return mb_strlen($this->str);
    }

    /**
     * 文字列の横幅を取得します
     *
     * @return int 文字列の横幅を返します
     */
    protected function getStrWidth(): int
    {
        return mb_strwidth($this->str);
    }
}
