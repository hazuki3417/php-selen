<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

use Selen\Data\Type;

final class Queue extends AbstractQueue
{
    /** @var string 型名またはクラス名 */
    private string $typeName;

    public function __construct(string $typeName)
    {
        $this->typeName = $typeName;
    }

    public function enqueue($object): void
    {
        $isExpectedType = Type::validate($object, $this->typeName);

        if (!$isExpectedType) {
            throw new \InvalidArgumentException('Invalid argument type.');
        }
        $this->objects[] = $object;
    }

    public function dequeue()
    {
        return array_shift($this->objects);
    }
}
