<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validate;

use ReflectionAttribute;
use ReflectionProperty;
use Selen\MongoDB\Attributes\Schema\ArrayValue;
use Selen\MongoDB\Attributes\Schema\Field;
use Selen\MongoDB\Attributes\Schema\Value;
use Selen\MongoDB\Attributes\Validate\ValueValidateInterface;

class FieldAttribute
{
    /** @var \ReflectionAttribute */
    public $fieldAttribute;

    /** @var \ReflectionAttribute|null */
    public $valueAttribute;

    /** @var \ReflectionAttribute|null */
    public $arrayValueAttribute;

    /** @var \ReflectionAttribute[] */
    public $validateAttributes = [];
    /** @var \ReflectionProperty */
    private $reflectionProperty;

    public function __construct(ReflectionProperty $reflectionProperty)
    {
        $this->reflectionProperty  = $reflectionProperty;
        $this->fieldAttribute      = self::extractFieldAttribute($reflectionProperty);
        $this->valueAttribute      = self::extractValueAttribute($reflectionProperty);
        $this->arrayValueAttribute = self::extractArrayValueAttribute($reflectionProperty);

        $isConflictAttribute = $this->valueAttribute !== null && $this->arrayValueAttribute !== null;

        if ($isConflictAttribute) {
            $format = 'Invalid attribute specification. %s and %s cannot be specified together.';
            $mes    = \sprintf($format, Value::class, ArrayValue);
            throw new \LogicException($mes);
        }

        // value,arrayValue,とvalidateAttributeは混在できないようにしゅうせいする　

        $this->validateAttributes = $reflectionProperty->getAttributes(
            ValueValidateInterface::class,
            ReflectionAttribute::IS_INSTANCEOF
        );
    }

    public static function extractFieldAttribute(ReflectionProperty $reflectionProperty)
    {
        $attributes             = $reflectionProperty->getAttributes(Field::class);
        $expectedAttributeCount = 1;

        if ($expectedAttributeCount !== count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, Field::class);
            throw new \LogicException($mes);
        }
        return \current($attributes);
    }

    public static function extractValueAttribute(ReflectionProperty $reflectionProperty)
    {
        $attributes = $reflectionProperty->getAttributes(Value::class);

        if ($attributes === []) {
            return;
        }

        $expectedAttributeCount = 1;

        if ($expectedAttributeCount !== count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, Value::class);
            throw new \LogicException($mes);
        }
        return \current($attributes);
    }

    public static function extractArrayValueAttribute(ReflectionProperty $reflectionProperty)
    {
        $attributes = $reflectionProperty->getAttributes(ArrayValue::class);

        if ($attributes === []) {
            return;
        }

        $expectedAttributeCount = 1;

        if ($expectedAttributeCount !== count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, ArrayValue::class);
            throw new \LogicException($mes);
        }
        return \current($attributes);
    }

    public function getFieldName(): string
    {
        return $this->reflectionProperty->getName();
    }

    public function isValidateAttributeExists(): bool
    {
        return $this->validateAttributes !== [];
    }

    public function isInnerObjectExists(): bool
    {
        return $this->valueAttribute !== null || $this->arrayValueAttribute !== null;
    }

    public function isValueObjectDefine(): bool
    {
        return !\is_null($this->valueAttribute);
    }

    public function isArrayObjectDefine(): bool
    {
        return !\is_null($this->arrayValueAttribute);
    }

    public static function isFieldAttributeExists(ReflectionProperty $reflectionProperty)
    {
        return $reflectionProperty->getAttributes(Field::class) !== [];
    }
}
