<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

abstract class AbstractStack extends AbstractObjects implements StackInterface
{
    /** @var mixed 要素の値 */
    private $workValue;

    /** @var int|string 要素のkey */
    private $workKey;

    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->workValue;
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->workKey;
    }

    public function next(): void
    {
        --$this->workKey;
        $this->workValue = array_pop($this->objects);
    }

    public function rewind(): void
    {
        end($this->objects);
        $this->workKey   = key($this->objects);
        $this->workValue = array_pop($this->objects);
    }

    public function valid(): bool
    {
        return $this->workValue !== null;
    }
}
