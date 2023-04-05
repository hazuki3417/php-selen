<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify;

use Selen\Str\Verify\Width;
use Selen\Verify\Str\Length;
use Selen\Verify\Str\Radixes\Radix;
use Selen\Verify\Str\Space;

class Str
{
    /**
     * @var Length
     */
    public $length;

    /**
     * @var Space
     */
    public $space;

    /**
     * @var Width
     */
    public $width;

    /**
     * @var string
     */
    private $str;

    private function __construct(string $val)
    {
        $this->str    = $val;
        $this->length = Length::set($this->str);
        $this->space  = Space::set($this->str);
        $this->width  = Width::set($this->str);
    }

    public static function set(string $val): Str
    {
        return new self($val);
    }

    public function radix(int $base): bool
    {
        return Radix::verify($this->str, $base);
    }

    public function length(): Length
    {
        return $this->length;
    }

    public function space(): Space
    {
        return $this->space;
    }

    public function width(): Width
    {
        return $this->width;
    }
}
