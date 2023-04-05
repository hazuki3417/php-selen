<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Verify\Width;

interface WidthInterface
{
    public function exist(): bool;

    public function notExist(): bool;

    public function only(): bool;

    public function notOnly(): bool;
}
