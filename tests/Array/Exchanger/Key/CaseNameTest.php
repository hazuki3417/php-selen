<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Array\Exchanger\Key;

use PHPUnit\Framework\TestCase;
use Selen\Array\Exchanger\Key\CaseName;

/**
 * @coversDefaultClass \Selen\Array\Exchanger\Key
 *
 * @see \Selen\Array\Exchanger\Key
 *
 * @internal
 */
class CaseNameTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderKebab(): array
    {
        return [
            'pattern001' => [
                'expected' => [
                    'TestValue1-0',
                    'test-key1-1' => 'TestValue1-1',
                    'TestValue1-2',
                    'test-key1-3' => 'TestValue1-3',
                    'test-key1-4' => [
                        'TestValue2-0',
                        'test-key2-1' => 'TestValue2-1',
                        'TestValue2-2',
                        'test-key2-3' => 'TestValue2-3',
                        'test-key2-4' => [
                            'TestValue3-0',
                            'test-key3-1' => 'TestValue3-1',
                            'TestValue3-2',
                            'test-key3-3' => 'TestValue3-3',
                        ],
                    ],
                ],
                'input' => [
                    'TestValue1-0',
                    'TestKey1-1' => 'TestValue1-1',
                    'TestValue1-2',
                    'TestKey1-3' => 'TestValue1-3',
                    'TestKey1-4' => [
                        'TestValue2-0',
                        'TestKey2-1' => 'TestValue2-1',
                        'TestValue2-2',
                        'TestKey2-3' => 'TestValue2-3',
                        'TestKey2-4' => [
                            'TestValue3-0',
                            'TestKey3-1' => 'TestValue3-1',
                            'TestValue3-2',
                            'TestKey3-3' => 'TestValue3-3',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderKebab
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testKebab($expected, $input): void
    {
        $actual = CaseName::kebab($input);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderSnake(): array
    {
        return [
            'pattern001' => [
                'expected' => [
                    'TestValue1-0',
                    'test_key1_1' => 'TestValue1-1',
                    'TestValue1-2',
                    'test_key1_3' => 'TestValue1-3',
                    'test_key1_4' => [
                        'TestValue2-0',
                        'test_key2_1' => 'TestValue2-1',
                        'TestValue2-2',
                        'test_key2_3' => 'TestValue2-3',
                        'test_key2_4' => [
                            'TestValue3-0',
                            'test_key3_1' => 'TestValue3-1',
                            'TestValue3-2',
                            'test_key3_3' => 'TestValue3-3',
                        ],
                    ],
                ],
                'input' => [
                    'TestValue1-0',
                    'TestKey1-1' => 'TestValue1-1',
                    'TestValue1-2',
                    'TestKey1-3' => 'TestValue1-3',
                    'TestKey1-4' => [
                        'TestValue2-0',
                        'TestKey2-1' => 'TestValue2-1',
                        'TestValue2-2',
                        'TestKey2-3' => 'TestValue2-3',
                        'TestKey2-4' => [
                            'TestValue3-0',
                            'TestKey3-1' => 'TestValue3-1',
                            'TestValue3-2',
                            'TestKey3-3' => 'TestValue3-3',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderSnake
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testSnake($expected, $input): void
    {
        $actual = CaseName::snake($input);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderPascal(): array
    {
        return [
            'pattern001' => [
                'expected' => [
                    'TestValue1-0',
                    'TestKey11' => 'TestValue1-1',
                    'TestValue1-2',
                    'TestKey13' => 'TestValue1-3',
                    'TestKey14' => [
                        'TestValue2-0',
                        'TestKey21' => 'TestValue2-1',
                        'TestValue2-2',
                        'TestKey23' => 'TestValue2-3',
                        'TestKey24' => [
                            'TestValue3-0',
                            'TestKey31' => 'TestValue3-1',
                            'TestValue3-2',
                            'TestKey33' => 'TestValue3-3',
                        ],
                    ],
                ],
                'input' => [
                    'TestValue1-0',
                    'test_key1_1' => 'TestValue1-1',
                    'TestValue1-2',
                    'test_key1_3' => 'TestValue1-3',
                    'test_key1_4' => [
                        'TestValue2-0',
                        'test_key2_1' => 'TestValue2-1',
                        'TestValue2-2',
                        'test_key2_3' => 'TestValue2-3',
                        'test_key2_4' => [
                            'TestValue3-0',
                            'test_key3_1' => 'TestValue3-1',
                            'TestValue3-2',
                            'test_key3_3' => 'TestValue3-3',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderPascal
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testPascal($expected, $input): void
    {
        $actual = CaseName::pascal($input);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderCamel(): array
    {
        return [
            'pattern001' => [
                'expected' => [
                    'TestValue1-0',
                    'testKey11' => 'TestValue1-1',
                    'TestValue1-2',
                    'testKey13' => 'TestValue1-3',
                    'testKey14' => [
                        'TestValue2-0',
                        'testKey21' => 'TestValue2-1',
                        'TestValue2-2',
                        'testKey23' => 'TestValue2-3',
                        'testKey24' => [
                            'TestValue3-0',
                            'testKey31' => 'TestValue3-1',
                            'TestValue3-2',
                            'testKey33' => 'TestValue3-3',
                        ],
                    ],
                ],
                'input' => [
                    'TestValue1-0',
                    'TestKey1-1' => 'TestValue1-1',
                    'TestValue1-2',
                    'TestKey1-3' => 'TestValue1-3',
                    'TestKey1-4' => [
                        'TestValue2-0',
                        'TestKey2-1' => 'TestValue2-1',
                        'TestValue2-2',
                        'TestKey2-3' => 'TestValue2-3',
                        'TestKey2-4' => [
                            'TestValue3-0',
                            'TestKey3-1' => 'TestValue3-1',
                            'TestValue3-2',
                            'TestKey3-3' => 'TestValue3-3',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCamel
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testCamel($expected, $input): void
    {
        $actual = CaseName::camel($input);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderLower(): array
    {
        return [
            'pattern001' => [
                'expected' => [
                    'TestValue1-0',
                    'testkey1-1' => 'TestValue1-1',
                    'TestValue1-2',
                    'testkey1-3' => 'TestValue1-3',
                    'testkey1-4' => [
                        'TestValue2-0',
                        'testkey2-1' => 'TestValue2-1',
                        'TestValue2-2',
                        'testkey2-3' => 'TestValue2-3',
                        'testkey2-4' => [
                            'TestValue3-0',
                            'testkey3-1' => 'TestValue3-1',
                            'TestValue3-2',
                            'testkey3-3' => 'TestValue3-3',
                        ],
                    ],
                ],
                'input' => [
                    'TestValue1-0',
                    'TestKey1-1' => 'TestValue1-1',
                    'TestValue1-2',
                    'TestKey1-3' => 'TestValue1-3',
                    'TestKey1-4' => [
                        'TestValue2-0',
                        'TestKey2-1' => 'TestValue2-1',
                        'TestValue2-2',
                        'TestKey2-3' => 'TestValue2-3',
                        'TestKey2-4' => [
                            'TestValue3-0',
                            'TestKey3-1' => 'TestValue3-1',
                            'TestValue3-2',
                            'TestKey3-3' => 'TestValue3-3',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderLower
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testLower($expected, $input): void
    {
        $actual = CaseName::lower($input);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderUpper(): array
    {
        return [
            'pattern001' => [
                'expected' => [
                    'TestValue1-0',
                    'TESTKEY1-1' => 'TestValue1-1',
                    'TestValue1-2',
                    'TESTKEY1-3' => 'TestValue1-3',
                    'TESTKEY1-4' => [
                        'TestValue2-0',
                        'TESTKEY2-1' => 'TestValue2-1',
                        'TestValue2-2',
                        'TESTKEY2-3' => 'TestValue2-3',
                        'TESTKEY2-4' => [
                            'TestValue3-0',
                            'TESTKEY3-1' => 'TestValue3-1',
                            'TestValue3-2',
                            'TESTKEY3-3' => 'TestValue3-3',
                        ],
                    ],
                ],
                'input' => [
                    'TestValue1-0',
                    'TestKey1-1' => 'TestValue1-1',
                    'TestValue1-2',
                    'TestKey1-3' => 'TestValue1-3',
                    'TestKey1-4' => [
                        'TestValue2-0',
                        'TestKey2-1' => 'TestValue2-1',
                        'TestValue2-2',
                        'TestKey2-3' => 'TestValue2-3',
                        'TestKey2-4' => [
                            'TestValue3-0',
                            'TestKey3-1' => 'TestValue3-1',
                            'TestValue3-2',
                            'TestKey3-3' => 'TestValue3-3',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderUpper
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testUpper($expected, $input): void
    {
        $actual = CaseName::upper($input);
        $this->assertSame($expected, $actual);
    }
}
