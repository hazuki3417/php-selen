<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

abstract class AbstractObjects implements ObjectsInterface
{
    /** @var array<mixed,mixed> オブジェクト */
    protected array $objects = [];

    /**
     * 新しいオブジェクトを作成します。
     *
     * @param array<mixed,mixed> $objects オブジェクトを渡します
     */
    public function __construct(array $objects)
    {
        $this->objects = $objects;
    }

    public function isEmpty(): bool
    {
        return $this->size() <= 0;
    }

    public function isNotEmpty(): bool
    {
        return 0 < $this->size();
    }

    public function size(): int
    {
        return count($this->objects);
    }

    public function clear(): void
    {
        $this->objects = [];
    }

    public function toArray(): array
    {
        return $this->objects;
    }
}
