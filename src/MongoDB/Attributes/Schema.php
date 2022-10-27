<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes;

use Attribute;
use LogicException;
use Selen\MongoDB\Attribute\SchemaMarkerInterface;

#[Attribute(Attribute::TARGET_CLASS)]
class Schema implements SchemaMarkerInterface
{
    public const TYPE_ROOT     = 'root';
    public const TYPE_INNER    = 'inner';
    private const TYPE_SCHEMAS = [
        self::TYPE_ROOT,
        self::TYPE_INNER,
    ];
    /** @var string */
    public $type;

    public function __construct(string $type)
    {
        if (!\in_array($type, self::TYPE_SCHEMAS, true)) {
            $format = 'Invalid value. Specify "%s" or "%s" for the schema type';
            $mes    = \sprintf($format, self::TYPE_ROOT, self::TYPE_INNER);
            throw new LogicException($mes);
        }
        $this->type = $type;
    }
}
