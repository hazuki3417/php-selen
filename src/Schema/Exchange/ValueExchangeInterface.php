<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Exchange;

interface ValueExchangeInterface
{
    /**
     * @param array<mixed,mixed> $value
     *
     * @return array<mixed,mixed>
     */
    public function execute($value);
}
