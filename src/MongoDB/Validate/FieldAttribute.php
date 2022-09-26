<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validate;

use ReflectionAttribute;
use ReflectionProperty;
use Selen\MongoDB\Attributes\Schema\ArrayValid;
use Selen\MongoDB\Attributes\Schema\Field;
use Selen\MongoDB\Attributes\Schema\Valid;
use Selen\MongoDB\Attributes\Validate\ValueValidateInterface;

class FieldAttribute
{
    /** @var \ReflectionAttribute */
    public $fieldAttribute;

    /** @var \ReflectionAttribute|null */
    public $validAttribute;

    /** @var \ReflectionAttribute|null */
    public $arrayValidAttribute;

    /** @var \ReflectionAttribute[] */
    public $validateAttributes = [];
    /** @var \ReflectionProperty */
    private $reflectionProperty;

    public function __construct(ReflectionProperty $reflectionProperty)
    {
        $this->reflectionProperty  = $reflectionProperty;
        $this->fieldAttribute      = self::extractFieldAttribute($reflectionProperty);
        $this->validAttribute      = self::extractValidAttribute($reflectionProperty);
        $this->arrayValidAttribute = self::extractArrayValidAttribute($reflectionProperty);

        $isConflictAttribute = $this->validAttribute !== null && $this->arrayValidAttribute !== null;

        if ($isConflictAttribute) {
            $format = 'Invalid attribute specification. %s and %s cannot be specified together.';
            $mes    = \sprintf($format, Valid::class, ArrayValid::class);
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

    public static function extractValidAttribute(ReflectionProperty $reflectionProperty)
    {
        $attributes = $reflectionProperty->getAttributes(Valid::class);

        if ($attributes === []) {
            return;
        }

        $expectedAttributeCount = 1;

        if ($expectedAttributeCount !== count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, Valid::class);
            throw new \LogicException($mes);
        }
        return \current($attributes);
    }

    public static function extractArrayValidAttribute(ReflectionProperty $reflectionProperty)
    {
        $attributes = $reflectionProperty->getAttributes(ArrayValid::class);

        if ($attributes === []) {
            return;
        }

        $expectedAttributeCount = 1;

        if ($expectedAttributeCount !== count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, ArrayValid::class);
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
        return $this->validAttribute !== null || $this->arrayValidAttribute !== null;
    }

    public function isValidObjectDefine(): bool
    {
        return !\is_null($this->validAttribute);
    }

    public function isArrayObjectDefine(): bool
    {
        return !\is_null($this->arrayValidAttribute);
    }

    public static function isFieldAttributeExists(ReflectionProperty $reflectionProperty)
    {
        return $reflectionProperty->getAttributes(Field::class) !== [];
    }
}
