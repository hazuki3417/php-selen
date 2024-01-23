<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Verify;

class Space
{
    /** @var string 検証対象の文字列 */
    private $str;

    private function __construct(string $val)
    {
        $this->str = $val;
    }

    public static function set(string $val): Space
    {
        return new self($val);
    }

    public function exist(): bool
    {
        return \preg_match('/[\s　]+/', $this->str);
    }

    public function notExist(): bool
    {
        return !$this->exist();
    }

    public function only(): bool
    {
        return \preg_match('/^[\s　]+$/', $this->str);
    }

    public function notOnly(): bool
    {
        return !$this->only();
    }
}
