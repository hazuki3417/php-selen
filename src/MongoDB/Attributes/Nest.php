<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes;

use Attribute;
use LogicException;
use Selen\MongoDB\Attribute\AttributeMarkerInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Nest implements AttributeMarkerInterface
{
    public const TYPE_OBJECT       = 'object';
    public const TYPE_ARRAY_OBJECT = 'arrayObject';
    private const TYPE_SCHEMAS     = [
        self::TYPE_OBJECT,
        self::TYPE_ARRAY_OBJECT,
    ];
    public string $type;
    public string $schemaClassName;

    public function __construct(string $type, string $schemaClassName)
    {
        if (!\in_array($type, self::TYPE_SCHEMAS, true)) {
            $format = 'Invalid value. Specify "%s" or "%s" for the nest type';
            $mes    = \sprintf($format, self::TYPE_OBJECT, self::TYPE_ARRAY_OBJECT);
            throw new LogicException($mes);
        }
        $this->type            = $type;
        $this->schemaClassName = $schemaClassName;
    }
}
