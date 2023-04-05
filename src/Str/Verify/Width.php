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
    private $str;

    private function __construct(string $val)
    {
        $this->str = $val;
    }

    public static function set(string $val): Width
    {
        return new self($val);
    }

    public function full()
    {
        return Full::set($this->str);
    }

    public function half()
    {
        return Half::set($this->str);
    }
}
