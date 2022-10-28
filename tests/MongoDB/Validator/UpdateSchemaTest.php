<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Validator;

use DateTime;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Selen\MongoDB\Attribute\SchemaLoader;
use Selen\MongoDB\Attributes\Nest;
use Selen\MongoDB\Attributes\Schema;
use Selen\MongoDB\Attributes\SchemaField;
use Selen\MongoDB\Validator\Attributes\ArrayType;
use Selen\MongoDB\Validator\Attributes\Enum;
use Selen\MongoDB\Validator\Attributes\Type;
use Selen\MongoDB\Validator\Model\ValidatorResult;
use Selen\MongoDB\Validator\UpdateSchema;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Validator\UpdateSchema
 *
 * @group Selen
 * @group Selen/MongoDB
 * @group Selen/MongoDB/Validator
 * @group Selen/MongoDB/Validator/UpdateSchema
 *
 * @see \Selen\MongoDB\Validator\UpdateSchema
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Validator/UpdateSchema
 *
 * @internal
 */
class UpdateSchemaTest extends TestCase
{
    public function testConstruct()
    {
        $schemaLoader = new SchemaLoader(new ReflectionClass(UpdateSchemaTestMockRootObject::class));
        $updateSchema = new UpdateSchema($schemaLoader);
        $this->assertInstanceOf(UpdateSchema::class, $updateSchema);
    }

    public function dataProviderExecute()
    {
        return [
            'validPattern:none validate' => [
                'expected' => [
                    'validateResults' => [],
                    'success'         => true,
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockNoneValidateObject::class,
                    'executeArgs'  => [],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param string $expected
     * @param array $input
     */
    public function testExecute($expected, $input)
    {
        [
            'contractArgs' => $contractArgs,
            'executeArgs'  => $executeArgs,
        ] = $input;

        $reflectionClass = new ReflectionClass($contractArgs);
        $schemaLoader    = new SchemaLoader($reflectionClass);
        $updateSchema    = new UpdateSchema($schemaLoader);
        $result          = $updateSchema->execute($executeArgs);

        [
            'success'         => $expectedSuccess,
            'validateResults' => $expectedValidateResults,
        ] = $expected;

        $this->assertInstanceOf(ValidatorResult::class, $result);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * Validatorクラスの返り値を検証するメソッド
     *
     * @param bool $expectedSuccess
     * @param \Selen\Schema\Validate\Model\ValidateResult[] $expectedValidateResults
     * @param \Selen\Schema\Validate\Model\ValidatorResult $result
     */
    private function assertValidatorClass($expectedSuccess, $expectedValidateResults, $result)
    {
        $this->assertSame($expectedSuccess, $result->success());

        $verifyValidateResults = $result->getValidateResults();

        $this->assertSame(
            count($expectedValidateResults),
            count($verifyValidateResults),
            '検証値のValidateResultsと期待値のValidateResultsの件数が一致しません'
        );

        foreach ($expectedValidateResults as $index => $expectedValidateResult) {
            // keyが存在したら中身の検証を行う
            $verifyValidateResult = $verifyValidateResults[$index];
            $mes                  = \sprintf('Failure index number: %s', $index);
            $this->assertSame(
                $expectedValidateResult->getResult(),
                $verifyValidateResult->getResult(),
                $mes
            );
            $this->assertSame(
                $expectedValidateResult->getArrayPath(),
                $verifyValidateResult->getArrayPath(),
                $mes
            );
            $this->assertSame(
                $expectedValidateResult->getMessage(),
                $verifyValidateResult->getMessage(),
                $mes
            );
        }
    }
}

/**
 * プロパティに設定された属性を元にバリデーションを提供する。
 * そのためプロパティに設定されている値に意味はありません。
 */
#[Schema('root')]
class UpdateSchemaTestMockNoneValidateObject
{
    #[SchemaField]
    public $rootObjField1;

    #[SchemaField]
    public $rootObjField2 = 0;

    #[SchemaField]
    public $rootObjField3 = 'val';

    #[SchemaField, Nest('object', UpdateSchemaTestMockInnerObject::class)]
    public $rootObjField4;

    #[SchemaField, Nest('arrayObject', UpdateSchemaTestMockInnerObjectItem::class)]
    public $rootObjField5;

    // NOTE: fieldとして扱わないプロパティ
    public $rootObjField6;
}

#[Schema('root')]
class UpdateSchemaTestMockRootObject
{
    #[SchemaField, Type('string', 'null')]
    public $rootObjField1;

    #[SchemaField, Type('int')]
    public $rootObjField2 = 0;

    #[SchemaField, Type('string')]
    public $rootObjField3 = 'val';

    // NOTE: object型のみ許可
    #[SchemaField, Nest('object', UpdateSchemaTestMockInnerObject::class)]
    public $rootObjField4;

    // NOTE: array object型のみ許可
    #[SchemaField, Nest('arrayObject', UpdateSchemaTestMockInnerObjectItem::class)]
    public $rootObjField5;

    // NOTE: null | object型を許可（typeにarrayを指定すること）
    #[SchemaField, Type('null', 'array'), Nest('object', UpdateSchemaTestMockInnerObject::class)]
    public $rootObjField6;

    // NOTE: null | array object型を許可（typeにarrayを指定すること）
    #[SchemaField, Type('null', 'array'), Nest('arrayObject', UpdateSchemaTestMockInnerObjectItem::class)]
    public $rootObjField7;

    // NOTE: fieldとして扱わないプロパティ
    public $rootObjField8;
}

#[Schema('inner')]
class UpdateSchemaTestMockInnerObject
{
    #[SchemaField, Type('string', 'null')]
    public $nestObjField1;

    #[SchemaField, Type('bool')]
    public $nestObjField2 = true;

    #[SchemaField, ArrayType('string')]
    public $nestObjField3 = [];

    #[SchemaField, ArrayType('int')]
    public $nestObjField4 = [];

    // NOTE: fieldとして扱わないプロパティ
    public $nestObjField5;
}

#[Schema('inner')]
class UpdateSchemaTestMockInnerObjectItem
{
    #[SchemaField, Enum('man', 'woman')]
    public $nestObjItemField1;

    #[SchemaField, Type(DateTime::class)]
    public $nestObjItemField2;

    // NOTE: fieldとして扱わないプロパティ
    public $nestObjItemField5;
}
