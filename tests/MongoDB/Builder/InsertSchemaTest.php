<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Builder;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Selen\MongoDB\Attribute\SchemaLoader;
use Selen\MongoDB\Attributes\Nest;
use Selen\MongoDB\Attributes\Schema;
use Selen\MongoDB\Attributes\SchemaField;
use Selen\MongoDB\Builder\Attributes\Build;
use Selen\MongoDB\Builder\InsertSchema;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Builder\InsertSchema
 *
 * @see InsertSchema
 *
 * @internal
 */
class InsertSchemaTest extends TestCase
{
    public function testConstruct()
    {
        $schemaLoader = new SchemaLoader(new ReflectionClass(InsertSchemaTestMockRootObject::class));
        $insertSchema = new InsertSchema($schemaLoader);
        $this->assertInstanceOf(InsertSchema::class, $insertSchema);
    }

    public function dataProviderCreate()
    {
        return [
            'validPattern:no input' => [
                'expected' => [
                    'rootObjField1' => null,
                    'rootObjField2' => 0,
                    'rootObjField3' => 'val',
                    'rootObjField4' => [
                        'nestObjField1' => null,
                        'nestObjField2' => true,
                        'nestObjField3' => [],
                        'nestObjField4' => [],
                    ],
                    'rootObjField5' => [],
                ],
                'input' => [
                    'contractArgs' => InsertSchemaTestMockRootObject::class,
                    'createArgs'   => [],
                ],
            ],
            'validPattern:Override non-nested field values' => [
                'expected' => [
                    'rootObjField1' => 10,
                    'rootObjField2' => 0,
                    'rootObjField3' => 'val',
                    'rootObjField4' => [
                        'nestObjField1' => null,
                        'nestObjField2' => true,
                        'nestObjField3' => [],
                        'nestObjField4' => [],
                    ],
                    'rootObjField5' => [],
                ],
                'input' => [
                    'contractArgs' => InsertSchemaTestMockRootObject::class,
                    'createArgs'   => [
                        'rootObjField1' => 10,
                        'rootObjField6' => 'Ignored key values',
                    ],
                ],
            ],
            'validPattern:Override field values in nested objects' => [
                'expected' => [
                    'rootObjField1' => 10,
                    'rootObjField2' => 0,
                    'rootObjField3' => 'val',
                    'rootObjField4' => [
                        'nestObjField1' => null,
                        'nestObjField2' => true,
                        'nestObjField3' => [],
                        'nestObjField4' => true,
                    ],
                    'rootObjField5' => [],
                ],
                'input' => [
                    'contractArgs' => InsertSchemaTestMockRootObject::class,
                    'createArgs'   => [
                        'rootObjField1' => 10,
                        'rootObjField4' => [
                            'nestObjField4' => true,
                        ],
                        'rootObjField6' => 'Ignored key values',
                    ],
                ],
            ],
            'invalidPattern:Override field values in nested objects' => [
                'expected' => [
                    'rootObjField1' => 10,
                    'rootObjField2' => 0,
                    'rootObjField3' => 'val',
                    'rootObjField4' => [
                        'nestObjField1' => null,
                        'nestObjField2' => true,
                        'nestObjField3' => [],
                        'nestObjField4' => [],
                    ],
                    'rootObjField5' => [],
                ],
                'input' => [
                    'contractArgs' => InsertSchemaTestMockRootObject::class,
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
                    'rootObjField2' => 0,
                    'rootObjField3' => 'val',
                    'rootObjField4' => [
                        'nestObjField1' => null,
                        'nestObjField2' => true,
                        'nestObjField3' => [],
                        'nestObjField4' => [],
                    ],
                    'rootObjField5' => [
                        [
                            'nestObjItemField1' => null,
                            'nestObjItemField2' => true,
                        ],
                    ],
                ],
                'input' => [
                    'contractArgs' => InsertSchemaTestMockRootObject::class,
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
            'invalidPattern:Override field values in nested array objects1' => [
                'expected' => [
                    'rootObjField1' => 10,
                    'rootObjField2' => 0,
                    'rootObjField3' => 'val',
                    'rootObjField4' => [
                        'nestObjField1' => null,
                        'nestObjField2' => true,
                        'nestObjField3' => [],
                        'nestObjField4' => [],
                    ],
                    'rootObjField5' => [],
                ],
                'input' => [
                    'contractArgs' => InsertSchemaTestMockRootObject::class,
                    'createArgs'   => [
                        'rootObjField1' => 10,
                        // NOTE: ArrayObjectの1次元目をリテラル型で上書き指定した場合は無視される
                        'rootObjField5' => true,
                        'rootObjField6' => 'Ignored key values',
                    ],
                ],
            ],
            'invalidPattern:Override field values in nested array objects2' => [
                'expected' => [
                    'rootObjField1' => 10,
                    'rootObjField2' => 0,
                    'rootObjField3' => 'val',
                    'rootObjField4' => [
                        'nestObjField1' => null,
                        'nestObjField2' => true,
                        'nestObjField3' => [],
                        'nestObjField4' => [],
                    ],
                    'rootObjField5' => [],
                ],
                'input' => [
                    'contractArgs' => InsertSchemaTestMockRootObject::class,
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
        $insertSchema    = new InsertSchema($schemaLoader);
        $result          = $insertSchema->create($createArgs);

        $this->assertSame($expected, $result);
    }
}

#[Schema('root')]
class InsertSchemaTestMockRootObject
{
    #[SchemaField]
    public $rootObjField1;

    #[SchemaField]
    public $rootObjField2 = 0;

    #[SchemaField]
    public $rootObjField3 = 'val';

    #[SchemaField, Nest('object', InsertSchemaTestMockInnerObject::class), Build]
    public $rootObjField4;

    #[SchemaField, Nest('arrayObject', InsertSchemaTestMockInnerObjectItem::class), Build]
    public $rootObjField5;

    // NOTE: fieldとして扱わないプロパティ
    public $rootObjField6;
}

#[Schema('inner')]
class InsertSchemaTestMockInnerObject
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
class InsertSchemaTestMockInnerObjectItem
{
    #[SchemaField]
    public $nestObjItemField1;

    #[SchemaField]
    public $nestObjItemField2;

    // NOTE: fieldとして扱わないプロパティ
    public $nestObjItemField5;
}
