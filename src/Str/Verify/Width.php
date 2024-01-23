<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Verify;

use Selen\Str\Verify\Width\Full;
use Selen\Str\Verify\Width\Half;

class Width
{
    /** @var string 検証対象の文字列 */
    private string $str;

    private function __construct(string $val)
    {
        $this->str = $val;
    }

    public static function set(string $val): Width
    {
        return new self($val);
    }

    public function full(): Full
    {
        return Full::set($this->str);
    }

    public function half(): Half
    {
        return Half::set($this->str);
    }
}
