<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

use Selen\Data\Type;

final class Collection extends AbstractCollection
{
    private $typeName;

    public function __construct(string $typeName)
    {
        $this->typeName = $typeName;
    }

    public function add($object)
    {
        $isExpectedType = Type::validate($this->typeName, $object);

        if (!$isExpectedType) {
            throw new \InvalidArgumentException('Invalid argument type.');
        }
        $this->objects[] = $object;

        return true;
    }

    public function remove($object)
    {
        $isExpectedType = Type::validate($this->typeName, $object);

        if (!$isExpectedType) {
            throw new \InvalidArgumentException('Invalid argument type.');
        }

        $index = \array_search($object, $this->objects, true);

        if ($index !== false) {
            unset($this->objects[$index]);
        }

        return true;
    }
}
