<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

class ArrayDepth
{
    /** @var int 階層の深さ */
    private int $currentIndex = 0;

    public function up(): bool
    {
        if ($this->currentIndex <= 0) {
            return false;
        }
        --$this->currentIndex;
        return true;
    }

    public function down(): bool
    {
        ++$this->currentIndex;
        return true;
    }

    public function current(): int
    {
        return $this->currentIndex;
    }
}
