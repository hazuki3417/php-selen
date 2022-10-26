<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attribute;

use LogicException;
use ReflectionAttribute;
use ReflectionProperty;
use Selen\MongoDB\Attributes\SchemaField;

/**
 * MongoDB SchemaのFieldに設定されたAttributeを読み込むクラス
 */
class SchemaFieldLoader
{
    public ReflectionProperty $reflectionProperty;

    public ReflectionAttribute|null $attributeFieldSchema;

    public function __construct(ReflectionProperty $reflectionProperty)
    {
        $this->reflectionProperty = $reflectionProperty;

        $attributes = $reflectionProperty->getAttributes(
            SchemaFieldMarkerInterface::class,
            ReflectionAttribute::IS_INSTANCEOF
        );

        if (1 < count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, SchemaField::class);
            throw new LogicException($mes);
        }

        $this->attributeFieldSchema = \array_shift($attributes);
    }

    /**
     * 属性を取得します
     *
     * @param string $attributeName 取得する属性名を渡します
     *
     * @return \ReflectionAttribute|null 存在する場合は属性を、存在しない場合はnullを返します
     */
    public function fetchAttribute(string $attributeName)
    {
        $attributes = $this->reflectionProperty->getAttributes(
            $attributeName,
            ReflectionAttribute::IS_INSTANCEOF
        );
        return \array_shift($attributes);
    }
}
