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
 * @see \Selen\MongoDB\Validator\Value
 *
 * @internal
 */
class ValueTest extends TestCase
{
    public function testConstruct()
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
#[Schema('root')]
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
}

#[Schema('root')]
class ValueTestMockRootObject
{
    #[SchemaField, Type('string', 'null')]
    public $rootObjField1;

    #[SchemaField, Type('int')]
    public $rootObjField2 = 0;

    #[SchemaField, Type('string')]
    public $rootObjField3 = 'val';
}
