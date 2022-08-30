<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

class Types
{
    public static function validate($data, string ...$typeNames): bool
    {
        $isDuplicateTypeName = count(\array_unique($typeNames)) < count($typeNames);

        if ($isDuplicateTypeName) {
            throw new \InvalidArgumentException('Duplicate type specification.');
        }

        $results = [];

        foreach ($typeNames as $typeName) {
            $results[] = Type::validate($data, $typeName);
        }
        return \in_array(true, $results, true);
    }
}