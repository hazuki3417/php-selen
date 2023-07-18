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
use Selen\MongoDB\Validator\Model\ValidateResult;
use Selen\MongoDB\Validator\Model\ValidatorResult;
use Selen\MongoDB\Validator\UpdateSchema;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Validator\UpdateSchema
 *
 * @see \Selen\MongoDB\Validator\UpdateSchema
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
            'validPattern:none validate all values strings' => [
                'expected' => [
                    'success'         => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockNoneValidateObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => '',
                        'rootObjField2' => '',
                        'rootObjField3' => '',
                        'rootObjField4' => '',
                        'rootObjField5' => '',
                    ],
                ],
            ],
            'validPattern:none validate all values boolean' => [
                'expected' => [
                    'success'         => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockNoneValidateObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => true,
                        'rootObjField2' => true,
                        'rootObjField3' => true,
                        'rootObjField4' => true,
                        'rootObjField5' => true,
                    ],
                ],
            ],
            'validPattern:passed validation have all the data' => [
                'expected' => [
                    'success'         => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField5' => [
                            [
                                'nestObjItemField1' => 'man',
                                'nestObjItemField2' => new DateTime(),
                            ],
                            [
                                'nestObjItemField1' => 'woman',
                                'nestObjItemField2' => new DateTime(),
                            ],
                        ],
                        'rootObjField6' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [],
                            'nestObjField4' => [],
                        ],
                        'rootObjField7' => [
                            [
                                'nestObjItemField1' => 'man',
                                'nestObjItemField2' => new DateTime(),
                            ],
                        ],
                        // 定義側に存在しないフィールドは無視される
                        'rootObjField0' => 'string value1',
                    ],
                ],
            ],
            'validPattern:passed validation rootObjField7 === []' => [
                'expected' => [
                    'success'         => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField5' => [
                            [
                                'nestObjItemField1' => 'man',
                                'nestObjItemField2' => new DateTime(),
                            ],
                            [
                                'nestObjItemField1' => 'woman',
                                'nestObjItemField2' => new DateTime(),
                            ],
                        ],
                        'rootObjField6' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [],
                            'nestObjField4' => [],
                        ],
                        'rootObjField7' => [],
                    ],
                ],
            ],
            'validPattern:passed validation rootObjField7 === null' => [
                'expected' => [
                    'success'         => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField5' => [
                            [
                                'nestObjItemField1' => 'man',
                                'nestObjItemField2' => new DateTime(),
                            ],
                            [
                                'nestObjItemField1' => 'woman',
                                'nestObjItemField2' => new DateTime(),
                            ],
                        ],
                        'rootObjField6' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [],
                            'nestObjField4' => [],
                        ],
                        'rootObjField7' => null,
                    ],
                ],
            ],
            'validPattern:passed validation rootObjField6 === null' => [
                'expected' => [
                    'success'         => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField5' => [
                            [
                                'nestObjItemField1' => 'man',
                                'nestObjItemField2' => new DateTime(),
                            ],
                            [
                                'nestObjItemField1' => 'woman',
                                'nestObjItemField2' => new DateTime(),
                            ],
                        ],
                        'rootObjField6' => null,
                        'rootObjField7' => null,
                    ],
                ],
            ],
            'validPattern:passed validation rootObjField5 === []' => [
                'expected' => [
                    'success'         => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField5' => [],
                        'rootObjField6' => null,
                        'rootObjField7' => null,
                    ],
                ],
            ],
            'invalidPattern:key validate. missing key' => [
                'expected' => [
                    // UpdateSchemaはinputに存在するkeyのみバリデーションする
                    'success'         => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        // 'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            // 'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField5' => [
                            [
                                'nestObjItemField1' => 'man',
                                'nestObjItemField2' => new DateTime(),
                            ],
                            [
                                'nestObjItemField1' => 'man',
                                // 'nestObjItemField2' => new DateTime(),
                            ],
                        ],
                        'rootObjField6' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            // 'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField7' => [
                            [
                                // 'nestObjItemField1' => 'man',
                                'nestObjItemField2' => new DateTime(),
                            ],
                        ],
                    ],
                ],
            ],
            'invalidPattern:value validate' => [
                'expected' => [
                    'success'         => false,
                    'validateResults' => [
                        new ValidateResult(false, 'rootObjField2', 'Invalid type. expected type int.'),
                        new ValidateResult(false, 'rootObjField4.nestObjField2', 'Invalid type. expected type bool.'),
                        new ValidateResult(false, 'rootObjField5.[1].nestObjItemField1', "Invalid value. expected value 'man', 'woman'."),
                        new ValidateResult(false, 'rootObjField6.nestObjField4', 'Invalid type. expected array element type int.'),
                        new ValidateResult(false, 'rootObjField7.[0].nestObjItemField1', "Invalid value. expected value 'man', 'woman'."),
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => true,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => [],
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField5' => [
                            [
                                'nestObjItemField1' => 'man',
                                'nestObjItemField2' => new DateTime(),
                            ],
                            [
                                'nestObjItemField1' => 'formal',
                                'nestObjItemField2' => new DateTime(),
                            ],
                        ],
                        'rootObjField6' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, '4'],
                        ],
                        'rootObjField7' => [
                            [
                                'nestObjItemField1' => 'formal',
                                'nestObjItemField2' => new DateTime(),
                            ],
                        ],
                    ],
                ],
            ],
            'invalidPattern:array format validate rootObjField4 === ""' => [
                'expected' => [
                    'success'         => false,
                    'validateResults' => [
                        new ValidateResult(false, 'rootObjField4', 'Invalid value. Expect "' . UpdateSchemaTestMockInnerObject::class . '" schema for array type'),
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        // Objectに相当する部分にリテラル値を渡したときの挙動
                        'rootObjField4' => '',
                        'rootObjField5' => [],
                        'rootObjField6' => null,
                        'rootObjField7' => null,
                    ],
                ],
            ],
            'invalidPattern:array format validate rootObjField4 === []' => [
                'expected' => [
                    'success'         => false,
                    'validateResults' => [
                        new ValidateResult(false, 'rootObjField4', 'Invalid value. Expect "' . UpdateSchemaTestMockInnerObject::class . '" schema for array type'),
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        // Objectに相当する部分に空配列を渡したときの挙動
                        'rootObjField4' => [],
                        'rootObjField5' => [],
                        'rootObjField6' => null,
                        'rootObjField7' => null,
                    ],
                ],
            ],
            'invalidPattern:array format validate rootObjField5 === [\'\']' => [
                'expected' => [
                    'success'         => false,
                    'validateResults' => [
                        new ValidateResult(false, 'rootObjField5.[0]', 'Invalid value. Expect "' . UpdateSchemaTestMockInnerObjectItem::class . '" schema for array type'),
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        // ArrayObjectの1要素に相当する部分にリテラル値を渡したときの挙動
                        'rootObjField5' => [''],
                        'rootObjField6' => null,
                        'rootObjField7' => null,
                    ],
                ],
            ],
            'invalidPattern:array format validate rootObjField5 === [[]]' => [
                'expected' => [
                    'success'         => false,
                    'validateResults' => [
                        new ValidateResult(false, 'rootObjField5.[0]', 'Invalid value. Expect "' . UpdateSchemaTestMockInnerObjectItem::class . '" schema for array type'),
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        // ArrayObjectの1要素に相当する部分に空配列を渡したときの挙動
                        'rootObjField5' => [[]],
                        'rootObjField6' => null,
                        'rootObjField7' => null,
                    ],
                ],
            ],
            'invalidPattern:array format validate rootObjField6 === []' => [
                'expected' => [
                    'success'         => false,
                    'validateResults' => [
                        new ValidateResult(false, 'rootObjField6', 'Invalid value. Expect "' . UpdateSchemaTestMockInnerObject::class . '" schema for array type'),
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField5' => [],
                        // Objectに相当する部分に空配列を渡したときの挙動
                        'rootObjField6' => [],
                        'rootObjField7' => null,
                    ],
                ],
            ],
            'invalidPattern:array format validate rootObjField7 === [\'\']' => [
                'expected' => [
                    'success'         => false,
                    'validateResults' => [
                        new ValidateResult(false, 'rootObjField7.[0]', 'Invalid value. Expect "' . UpdateSchemaTestMockInnerObjectItem::class . '" schema for array type'),
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField5' => [],
                        'rootObjField6' => null,
                        // ArrayObjectの1要素に相当する部分に空配列を渡したときの挙動
                        'rootObjField7' => [''],
                    ],
                ],
            ],
            'invalidPattern:array format validate rootObjField7 === [[]]' => [
                'expected' => [
                    'success'         => false,
                    'validateResults' => [
                        new ValidateResult(false, 'rootObjField7.[0]', 'Invalid value. Expect "' . UpdateSchemaTestMockInnerObjectItem::class . '" schema for array type'),
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'executeArgs'  => [
                        'rootObjField1' => 'string value1',
                        'rootObjField2' => 10,
                        'rootObjField3' => 'string value2',
                        'rootObjField4' => [
                            'nestObjField1' => 'string nest value1',
                            'nestObjField2' => true,
                            'nestObjField3' => [
                                'string nest value2',
                                'string nest value3',
                                'string nest value4',
                            ],
                            'nestObjField4' => [1, 2, 3, 4],
                        ],
                        'rootObjField5' => [],
                        'rootObjField6' => null,
                        // ArrayObjectの1要素に相当する部分に空配列を渡したときの挙動
                        'rootObjField7' => [[]],
                    ],
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

    #[SchemaField]
    public $rootObjField4;

    #[SchemaField]
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
