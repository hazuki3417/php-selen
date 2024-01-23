<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Validator;

use PHPUnit\Framework\TestCase;
use ReflectionAttribute;
use Selen\Data\ArrayPath;
use Selen\MongoDB\Attributes\Nest;
use Selen\MongoDB\Attributes\Schema;
use Selen\MongoDB\Attributes\SchemaField;
use Selen\MongoDB\Validator\Attributes\Type;
use Selen\MongoDB\Validator\Value;
use Selen\MongoDB\Validator\ValueValidateInterface;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Validator\Value
 *
 * @see Value
 *
 * @internal
 */
class ValueTest extends TestCase
{
    public function testConstruct(): void
    {
        $arrayPath          = new ArrayPath();
        $reflectionClass    = new \ReflectionClass(ValueTestMockNoneValidateObject::class);
        $attributeValidates = $reflectionClass
            ->getProperty('rootObjField1')
            ->getAttributes(ValueValidateInterface::class, ReflectionAttribute::IS_INSTANCEOF);

        $updateSchema = new Value($arrayPath, $attributeValidates);
        $this->assertInstanceOf(Value::class, $updateSchema);
    }
}

/**
 * プロパティに設定された属性を元にバリデーションを提供する。
 * そのためプロパティに設定されている値に意味はありません。
 */
#[Schema(Schema::TYPE_ROOT)]
class ValueTestMockNoneValidateObject
{
    #[SchemaField]
    public $rootObjField1;

    #[SchemaField]
    public $rootObjField2 = 0;

    #[SchemaField]
    public $rootObjField3 = 'val';

    #[SchemaField, Nest('object', ValueTestMockInnerObject::class)]
    public $rootObjField4;

    #[SchemaField, Nest('arrayObject', ValueTestMockInnerObjectItem::class)]
    public $rootObjField5;

    // NOTE: fieldとして扱わないプロパティ
    public $rootObjField6;

    /**
     * NOTE: string | array[string] という型定義はできない（型定義の属性クラスを複数指定した場合、指定した型定義同士はandで判定するため）
     *       - value type: string           > ng
     *       - value type: array empty      > ok
     *       - value type: array string     > ok
     *       - value type: array not string > ng
     *       複数の型定義属性をorで判定した場合、型定義の実装によっては型がゆるくなるためやらない
     *       （ライブラリ側の設計方針は変えないので、DB設計を見直しての方針）
     */
    // #[SchemaField, ArrayType('string'), Type('string', 'array')]
    // public $rootObjField7;
}

#[Schema(Schema::TYPE_INNER)]
class ValueTestMockInnerObject
{
    #[SchemaField, Type('string', 'null')]
    public $innerObjField1;

    #[SchemaField, Type('int')]
    public $innerObjField2 = 0;

    #[SchemaField, Type('string')]
    public $innerObjField3 = 'val';
}

#[Schema(Schema::TYPE_INNER)]
class ValueTestMockInnerObjectItem
{
    #[SchemaField, Type('string', 'null')]
    public $innerObjField1;

    #[SchemaField, Type('int')]
    public $innerObjField2 = 0;

    #[SchemaField, Type('string')]
    public $innerObjField3 = 'val';
}
