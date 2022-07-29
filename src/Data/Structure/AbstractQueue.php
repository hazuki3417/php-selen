<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

abstract class AbstractQueue extends AbstractObjects implements QueueInterface
{
    private $workValue;

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
        ++$this->workKey;
        $this->workValue = array_shift($this->objects);
    }

    public function rewind(): void
    {
        reset($this->objects);
        $this->workKey = key($this->objects);
        $this->workValue = array_shift($this->objects);
    }

    public function valid(): bool
    {
        return $this->workValue !== null;
    }
}
