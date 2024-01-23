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
use Selen\MongoDB\Attributes\Nest;
use Selen\MongoDB\Attributes\SchemaField;

/**
 * MongoDB SchemaのFieldに設定されたAttributeを読み込むクラス
 */
class SchemaFieldLoader
{
    /** @var ReflectionProperty */
    public $reflectionProperty;

    /** @var \ReflectionAttribute<SchemaFieldMarkerInterface>|null */
    public $attributeFieldSchema;

    /** @var \ReflectionAttribute<Nest>|null */
    public $attributeNest;

    public function __construct(ReflectionProperty $reflectionProperty)
    {
        $this->reflectionProperty = $reflectionProperty;

        $attributes = $this->fetchAttributes(SchemaFieldMarkerInterface::class);

        if (1 < count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, SchemaField::class);
            throw new LogicException($mes);
        }

        $this->attributeFieldSchema = \array_shift($attributes);
        $this->attributeNest        = $this->fetchAttribute(Nest::class);
    }

    /**
     * 属性を取得します（1件）
     *
     * @param string $attributeName 取得する属性名を渡します
     *
     * @return \ReflectionAttribute<object>|null 存在する場合は属性を、存在しない場合はnullを返します
     */
    public function fetchAttribute(string $attributeName)
    {
        $attributes = $this->reflectionProperty->getAttributes(
            $attributeName,
            ReflectionAttribute::IS_INSTANCEOF
        );
        return \array_shift($attributes);
    }

    /**
     * 属性を取得します（n件）
     *
     * @param string $attributeName 取得する属性名を渡します
     *
     * @return \ReflectionAttribute<object>[] 存在する場合は属性を保持した配列を、存在しない場合は空配列を返します
     */
    public function fetchAttributes(string $attributeName)
    {
        return $this->reflectionProperty->getAttributes(
            $attributeName,
            ReflectionAttribute::IS_INSTANCEOF
        );
    }
}
