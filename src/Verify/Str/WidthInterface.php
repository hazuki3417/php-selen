<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str;

interface WidthInterface
{
    public function full(): StatusInterface;

    public function half(): StatusInterface;
}
