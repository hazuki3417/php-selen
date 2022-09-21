<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validate;

use ReflectionClass;
use Selen\MongoDB\Attributes\Schema\InnerObject;
use Selen\MongoDB\Attributes\Schema\RootObject;

class ObjectAttribute
{
    public static function extractRootObjectAttribute(ReflectionClass $reflectionClass)
    {
        $attributes             = $reflectionClass->getAttributes(RootObject::class);
        $expectedAttributeCount = 1;

        if ($expectedAttributeCount !== count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, RootObject::class);
            throw new \LogicException($mes);
        }
        return \current($attributes);
    }

    public static function extractInnerObjectAttribute(ReflectionClass $reflectionClass)
    {
        $attributes             = $reflectionClass->getAttributes(InnerObject::class);
        $expectedAttributeCount = 1;

        if ($expectedAttributeCount !== count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, InnerObject::class);
            throw new \LogicException($mes);
        }
        return \current($attributes);
    }
}
