<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Verify\Width;

class Half extends AbstractWidth
{
    private function __construct(string $val)
    {
        parent::__construct($val);
    }

    public static function set(string $val): Half
    {
        return new self($val);
    }

    public function exist(): bool
    {
        if ($this->str === '') {
            return false;
        }
        return $this->getStrWidth() !== $this->calcStrAllFullWidth();
    }

    public function notExist(): bool
    {
        if ($this->str === '') {
            return true;
        }
        return $this->getStrWidth() === $this->calcStrAllFullWidth();
    }

    public function only(): bool
    {
        if ($this->str === '') {
            return false;
        }
        return $this->getStrWidth() === $this->calcStrAllHalfWidth();
    }

    public function notOnly(): bool
    {
        if ($this->str === '') {
            return true;
        }
        return $this->getStrWidth() !== $this->calcStrAllHalfWidth();
    }
}
