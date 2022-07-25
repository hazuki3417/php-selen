<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str\Width;

use Selen\Verify\Str\StatusInterface;

class Full implements StatusInterface
{
    public const FULL_CHARACTER_WIDTH = 2;
    private $str;

    private function __construct(string $val)
    {
        $this->str = $val;
    }

    public static function set(string $val): Full
    {
        return new self($val);
    }

    public function exist(): bool
    {
        if ($this->str === '') {
            return false;
        }
        // NOTE: 文字数と文字幅を比較
        return mb_strlen($this->str) !== mb_strwidth($this->str);
    }

    public function notExist(): bool
    {
        if ($this->str === '') {
            return false;
        }
        // NOTE: 文字数と文字幅を比較
        return mb_strlen($this->str) === mb_strwidth($this->str);
    }

    public function only(): bool
    {
        if ($this->str === '') {
            return false;
        }
        $calcMbStrWidth = mb_strlen($this->str) * self::FULL_CHARACTER_WIDTH;

        return $calcMbStrWidth === mb_strwidth($this->str);
    }

    public function notOnly(): bool
    {
        if ($this->str === '') {
            return false;
        }
        $calcMbStrWidth = mb_strlen($this->str) * self::FULL_CHARACTER_WIDTH;

        return $calcMbStrWidth !== mb_strwidth($this->str);
    }
}
