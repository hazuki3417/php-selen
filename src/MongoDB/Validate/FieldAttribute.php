<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validate;

use ReflectionAttribute;
use ReflectionProperty;
use Selen\MongoDB\Attributes\Schema\SchemaMarkerInterface;
use Selen\MongoDB\Attributes\Validate\ValueValidateInterface;

class FieldAttribute
{
    /** @var \ReflectionProperty */
    public $reflectionProperty;

    /** @var \ReflectionAttribute[] */
    public $schemaAttributes = [];

    /** @var \ReflectionAttribute[] */
    public $validateAttributes = [];

    public function __construct(ReflectionProperty $reflectionProperty)
    {
        $this->reflectionProperty = $reflectionProperty;
        $this->schemaAttributes   = $reflectionProperty->getAttributes(
                SchemaMarkerInterface::class,
                ReflectionAttribute::IS_INSTANCEOF
            );

        $this->validateAttributes = $reflectionProperty->getAttributes(
                ValueValidateInterface::class,
                ReflectionAttribute::IS_INSTANCEOF
            );
    }

    public function getFieldName(): string
    {
        return $this->reflectionProperty->getName();
    }

    public function isSchemaAttributeExists(): bool
    {
        return $this->schemaAttributes !== [];
    }

    public function isValidateAttributeExists(): bool
    {
        return $this->validateAttributes !== [];
    }
}
