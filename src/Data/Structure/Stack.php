<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

final class Stack extends AbstractStack
{
    private $typeName;

    public function __construct(string $typeName)
    {
        $this->typeName = $typeName;
    }

    public function push($object)
    {
        $isExpectedType = Types::validate($this->typeName, $object);

        if (!$isExpectedType) {
            throw new \InvalidArgumentException('Invalid argument type.');
        }
        $this->objects[] = $object;
    }

    public function pop()
    {
        return array_pop($this->objects);
    }
}
