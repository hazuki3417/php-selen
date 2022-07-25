<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str;

use Selen\Verify\Str\Width\Full;
use Selen\Verify\Str\Width\Half;

class Width implements WidthInterface
{
    private $str;

    private function __construct(string $val)
    {
        $this->str = $val;
    }

    public static function set(string $val): Width
    {
        return new self($val);
    }

    public function full(): StatusInterface
    {
        return Full::set($this->str);
    }

    public function half(): StatusInterface
    {
        return Half::set($this->str);
    }
}
