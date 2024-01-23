<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Builder;

use LogicException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Selen\MongoDB\Attribute\SchemaLoader;
use Selen\MongoDB\Attributes\Nest;
use Selen\MongoDB\Attributes\Schema;
use Selen\MongoDB\Attributes\SchemaField;
use Selen\MongoDB\Builder\Attributes\Build;
use Selen\MongoDB\Builder\UpdateSchema;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Builder\UpdateSchema
 *
 * @see UpdateSchema
 *
 * @internal
 */
class UpdateSchemaTest extends TestCase
{
    public function testConstruct()
    {
        $SchemaLoader = new SchemaLoader(new ReflectionClass(UpdateSchemaTestMockRootObject::class));
        $insertSchema = new UpdateSchema($SchemaLoader);
        $this->assertInstanceOf(UpdateSchema::class, $insertSchema);
    }

    public function dataProviderCreateException()
    {
        return [
            'invalidPattern:no input' => [
                'expected' => LogicException::class,
                'input'    => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'createArgs'   => [],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCreateException
     *
     * @param string $expected
     * @param array  $input
     */
    public function testCreateException($expected, $input)
    {
        [
            'contractArgs' => $contractArgs,
            'createArgs'   => $createArgs,
        ] = $input;

        $reflectionClass = new ReflectionClass($contractArgs);
        $schemaLoader    = new SchemaLoader($reflectionClass);
        $updateSchema    = new UpdateSchema($schemaLoader);

        $this->expectException($expected);
        $updateSchema->create($createArgs);
    }

    public function dataProviderCreate()
    {
        return [
            'validPattern:Override non-nested field values' => [
                'expected' => [
                    'rootObjField1' => 10,
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'createArgs'   => [
                        'rootObjField1' => 10,
                        'rootObjField6' => 'Ignored key values',
                    ],
                ],
            ],
            'validPattern:Override field values in nested objects' => [
                'expected' => [
                    'rootObjField1' => 10,
                    'rootObjField4' => [
                        'nestObjField4' => true,
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'createArgs'   => [
                        'rootObjField1' => 10,
                        'rootObjField4' => [
                            'nestObjField4' => true,
                        ],
                        'rootObjField6' => 'Ignored key values',
                    ],
                ],
            ],
            // TODO: このパターンを例外として扱うかどうか検討
            'invalidPattern:Override field values in nested objects' => [
                'expected' => [
                    'rootObjField1' => 10,
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'createArgs'   => [
                        'rootObjField1' => 10,
                        // NOTE: Objectの1次元目をリテラル型で上書き指定した場合は無視される
                        'rootObjField4' => true,
                        'rootObjField6' => 'Ignored key values',
                    ],
                ],
            ],
            'validPattern:Override field values in nested array objects' => [
                'expected' => [
                    'rootObjField1' => 10,
                    'rootObjField5' => [
                        [
                            'nestObjItemField2' => true,
                        ],
                    ],
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'createArgs'   => [
                        'rootObjField1' => 10,
                        'rootObjField5' => [
                            [
                                'nestObjItemField2' => true,
                            ],
                        ],
                        'rootObjField6' => 'Ignored key values',
                    ],
                ],
            ],
            // TODO: このパターンを例外として扱うかどうか検討
            'invalidPattern:Override field values in nested array objects1' => [
                'expected' => [
                    'rootObjField1' => 10,
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'createArgs'   => [
                        'rootObjField1' => 10,
                        // NOTE: ArrayObjectの1次元目をリテラル型で上書き指定した場合は無視される
                        'rootObjField5' => true,
                        'rootObjField6' => 'Ignored key values',
                    ],
                ],
            ],
            // TODO: このパターンを例外として扱うかどうか検討
            'invalidPattern:Override field values in nested array objects2' => [
                'expected' => [
                    'rootObjField1' => 10,
                ],
                'input' => [
                    'contractArgs' => UpdateSchemaTestMockRootObject::class,
                    'createArgs'   => [
                        'rootObjField1' => 10,
                        // NOTE: ArrayObjectの2次元目をリテラル型で上書き指定した場合は無視される
                        'rootObjField5' => [
                            'dummy value1',
                            'dummy value2',
                        ],
                        'rootObjField6' => 'Ignored key values',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCreate
     *
     * @param string $expected
     * @param array  $input
     */
    public function testCreate($expected, $input)
    {
        [
            'contractArgs' => $contractArgs,
            'createArgs'   => $createArgs,
        ] = $input;

        $reflectionClass = new ReflectionClass($contractArgs);
        $schemaLoader    = new SchemaLoader($reflectionClass);
        $updateSchema    = new UpdateSchema($schemaLoader);
        $result          = $updateSchema->create($createArgs);

        $this->assertSame($expected, $result);
    }
}

#[Schema('root')]
class UpdateSchemaTestMockRootObject
{
    #[SchemaField]
    public $rootObjField1;

    #[SchemaField]
    public $rootObjField2 = 0;

    #[SchemaField]
    public $rootObjField3 = 'val';

    #[SchemaField, Nest('object', UpdateSchemaTestMockInnerObject::class), Build]
    public $rootObjField4;

    #[SchemaField, Nest('arrayObject', UpdateSchemaTestMockInnerObjectItem::class), Build]
    public $rootObjField5;

    // NOTE: fieldとして扱わないプロパティ
    public $rootObjField6;
}

#[Schema('inner')]
class UpdateSchemaTestMockInnerObject
{
    #[SchemaField]
    public $nestObjField1;

    #[SchemaField]
    public $nestObjField2 = true;

    #[SchemaField]
    public $nestObjField3 = [];

    #[SchemaField]
    public $nestObjField4 = [];

    // NOTE: fieldとして扱わないプロパティ
    public $nestObjField5;
}

#[Schema('inner')]
class UpdateSchemaTestMockInnerObjectItem
{
    #[SchemaField]
    public $nestObjItemField1;

    #[SchemaField]
    public $nestObjItemField2;

    // NOTE: fieldとして扱わないプロパティ
    public $nestObjItemField5;
}
