<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str\Radixes;

class Radix16 extends AbstractRadix
{
    public const CARDINALITY    = 16;
    public const NUMBER_RANGE   = '0-9';
    public const ALPHABET_RANGE = 'a-f';
}
