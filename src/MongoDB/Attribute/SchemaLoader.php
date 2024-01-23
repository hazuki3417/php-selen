<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attribute;

use LogicException;
use ReflectionAttribute;
use ReflectionClass;
use Selen\MongoDB\Attributes\Schema;

/**
 * MongoDB Schemaに設定されたAttributeを読み込むクラス
 */
class SchemaLoader
{
    /** @var ReflectionClass<object> */
    public $reflectionClass;

    /** @var \ReflectionAttribute<SchemaMarkerInterface>|null */
    public $attributeSchema;

    /** @var array<string,SchemaFieldLoader> key: fieldName, value: instance */
    public $fieldLoaders;

    /**
     * @param ReflectionClass<object> $reflectionClass MongoDB Schemaのクラス名を渡します
     *
     * @throws LogicException 属性の指定が不正なときに発生します
     */
    public function __construct(ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;

        $attributes = $reflectionClass->getAttributes(
            SchemaMarkerInterface::class,
            ReflectionAttribute::IS_INSTANCEOF
        );

        if (1 < count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, Schema::class);
            throw new LogicException($mes);
        }

        $this->attributeSchema = \array_shift($attributes);

        $properties = $reflectionClass->getProperties();

        $fieldLoaders = [];

        foreach ($properties as $property) {
            $schemaFieldLoader = new SchemaFieldLoader($property);

            if ($schemaFieldLoader->attributeFieldSchema === null) {
                // SchemaField属性がないものは対象外
                continue;
            }
            $fieldLoaders[$property->getName()] = $schemaFieldLoader;
        }
        $this->fieldLoaders = $fieldLoaders;
    }
}
