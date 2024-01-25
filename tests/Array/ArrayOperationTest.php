<?php

declare(strict_types=1);

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2024 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Array;

use ArrayIterator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Selen\Array\ArrayOperation;

/**
 * @coversDefaultClass \Selen\Array\ArrayOperation
 *
 * @see ArrayOperation
 *
 * @internal
 */
class ArrayOperationTest extends TestCase
{
    public function testConstruct()
    {
        $arrayIterator = new ArrayIterator([1, 2, 3]);
        $actual        = new ArrayOperation($arrayIterator);
        $this->assertInstanceOf(ArrayOperation::class, $actual);
    }

    public function testSet()
    {
        $actual = ArrayOperation::set([1, 2, 3]);
        $this->assertInstanceOf(ArrayOperation::class, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderFilterByElement(): array
    {
        $testArrayData = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'value4', // keyが省略されているが実際には 0 => 'value4' という定義
            'value5', // keyが省略されているが実際には 1 => 'value5' という定義
            'value6', // keyが省略されているが実際には 2 => 'value6' という定義
        ];

        return [
            'invalid: 想定していないRETURN_CONDITIONを指定' => [
                'expected' => [],
                'input'    => [
                    'construct'       => new ArrayIterator($testArrayData),
                    'filterByElement' => [],
                    'get'             => '想定していないRETURN_CONDITIONを指定',
                ],
                'exception' => InvalidArgumentException::class,
            ],
            'valid: $testArrayDataの要素に対して検索をおこない、一致した要素のkeyを取得' => [
                'expected' => [
                    // NOTE: keyのみを取得するため、返り値の添字要素は振り直される
                    0 => 'key2',
                    1 => 1,
                    2 => 2,
                ],
                'input' => [
                    'construct'       => new ArrayIterator($testArrayData),
                    'filterByElement' => [
                        'key2' => 'value2', // key,value両方一致する要素
                        1      => 'value5', // key,value両方一致する要素
                        2      => 'value6', // key,value両方一致する要素
                        '9'    => 'value4', // keyが一致しない要素
                        'key1' => 'value3', // valueが一致しない要素
                    ],
                    'get' => ArrayOperation::RETURN_CONDITION_KEY,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataの要素に対して検索をおこない、一致した要素のvalueを取得' => [
                'expected' => [
                    // NOTE: valueのみを取得するため、返り値の添字要素は振り直される
                    0 => 'value2',
                    1 => 'value5',
                    2 => 'value6',
                ],
                'input' => [
                    'construct'       => new ArrayIterator($testArrayData),
                    'filterByElement' => [
                        'key2' => 'value2', // key,value両方一致する要素
                        1      => 'value5', // key,value両方一致する要素
                        2      => 'value6', // key,value両方一致する要素
                        '9'    => 'value4', // keyが一致しない要素
                        'key1' => 'value3', // valueが一致しない要素
                    ],
                    'get' => ArrayOperation::RETURN_CONDITION_VALUE,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataの要素に対して検索をおこない、一致した要素のkey,valueを取得' => [
                'expected' => [
                    // NOTE: key,valueを取得するため、返り値の添字要素は維持される
                    'key2' => 'value2',
                    1      => 'value5',
                    2      => 'value6',
                ],
                'input' => [
                    'construct'       => new ArrayIterator($testArrayData),
                    'filterByElement' => [
                        'key2' => 'value2', // key,value両方一致する要素
                        1      => 'value5', // key,value両方一致する要素
                        2      => 'value6', // key,value両方一致する要素
                        '9'    => 'value4', // keyが一致しない要素
                        'key1' => 'value3', // valueが一致しない要素
                    ],
                    'get' => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataの要素に対して検索をおこない、一致した要素のkeyを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct'       => new ArrayIterator([]),
                    'filterByElement' => [
                        'key2' => 'value2', // key,value両方一致する要素
                        1      => 'value5', // key,value両方一致する要素
                        2      => 'value6', // key,value両方一致する要素
                        '9'    => 'value4', // keyが一致しない要素
                        'key1' => 'value3', // valueが一致しない要素
                    ],
                    'get' => ArrayOperation::RETURN_CONDITION_KEY,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataの要素に対して検索をおこない、一致した要素のvalueを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct'       => new ArrayIterator([]),
                    'filterByElement' => [
                        'key2' => 'value2', // key,value両方一致する要素
                        1      => 'value5', // key,value両方一致する要素
                        2      => 'value6', // key,value両方一致する要素
                        '9'    => 'value4', // keyが一致しない要素
                        'key1' => 'value3', // valueが一致しない要素
                    ],
                    'get' => ArrayOperation::RETURN_CONDITION_VALUE,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataの要素に対して検索をおこない、一致した要素のkey,valueを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct'       => new ArrayIterator([]),
                    'filterByElement' => [
                        'key2' => 'value2', // key,value両方一致する要素
                        1      => 'value5', // key,value両方一致する要素
                        2      => 'value6', // key,value両方一致する要素
                        '9'    => 'value4', // keyが一致しない要素
                        'key1' => 'value3', // valueが一致しない要素
                    ],
                    'get' => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderFilterByElement
     *
     * @group test
     *
     * @param mixed $expected
     * @param mixed $input
     * @param mixed $exception
     */
    public function testFilterByElement($expected, $input, $exception): void
    {
        [
            'construct'       => $construct,
            'filterByElement' => $filterByElement,
            'get'             => $get,
        ] = $input;

        $instance = new ArrayOperation($construct);

        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $instance->filterByElement($filterByElement)->get($get);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderFilterByKey(): array
    {
        $testArrayData = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'value4', // keyが省略されているが実際には 0 => 'value4' という定義
            'value5', // keyが省略されているが実際には 1 => 'value5' という定義
            'value6', // keyが省略されているが実際には 2 => 'value6' という定義
        ];

        return [
            'invalid: 想定していないRETURN_CONDITIONを指定' => [
                'expected' => [],
                'input'    => [
                    'construct'   => new ArrayIterator($testArrayData),
                    'filterByKey' => [],
                    'get'         => '想定していないRETURN_CONDITIONを指定',
                ],
                'exception' => InvalidArgumentException::class,
            ],
            'valid: $testArrayDataのkeyに対して検索をおこない、一致した要素のkeyを取得' => [
                'expected' => [
                    // NOTE: keyのみを取得するため、返り値の添字要素は振り直される
                    0 => 'key2',
                    1 => 1,
                    2 => 2,
                ],
                'input' => [
                    'construct'   => new ArrayIterator($testArrayData),
                    'filterByKey' => ['key2', 1, 2],
                    'get'         => ArrayOperation::RETURN_CONDITION_KEY,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのkeyに対して検索をおこない、一致した要素のvalueを取得' => [
                'expected' => [
                    // NOTE: valueのみを取得するため、返り値の添字要素は振り直される
                    0 => 'value2',
                    1 => 'value5',
                    2 => 'value6',
                ],
                'input' => [
                    'construct'   => new ArrayIterator($testArrayData),
                    'filterByKey' => ['key2', 1, 2],
                    'get'         => ArrayOperation::RETURN_CONDITION_VALUE,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのkeyに対して検索をおこない、一致した要素のkey,valueを取得' => [
                'expected' => [
                    // NOTE: key,valueを取得するため、返り値の添字要素は維持される
                    'key2' => 'value2',
                    1      => 'value5',
                    2      => 'value6',
                ],
                'input' => [
                    'construct'   => new ArrayIterator($testArrayData),
                    'filterByKey' => ['key2', 1, 2],
                    'get'         => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのkeyに対して検索をおこない、一致した要素のkeyを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct'   => new ArrayIterator([]),
                    'filterByKey' => ['key2', 1, 2],
                    'get'         => ArrayOperation::RETURN_CONDITION_KEY,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのkeyに対して検索をおこない、一致した要素のvalueを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct'   => new ArrayIterator([]),
                    'filterByKey' => ['key2', 1, 2],
                    'get'         => ArrayOperation::RETURN_CONDITION_VALUE,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのkeyに対して検索をおこない、一致した要素のkey,valueを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct'   => new ArrayIterator([]),
                    'filterByKey' => ['key2', 1, 2],
                    'get'         => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderFilterByKey
     *
     * @param mixed $expected
     * @param mixed $input
     * @param mixed $exception
     */
    public function testFilterByKey($expected, $input, $exception): void
    {
        [
            'construct'   => $construct,
            'filterByKey' => $filterByKey,
            'get'         => $get,
        ] = $input;

        $instance = new ArrayOperation($construct);

        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $instance->filterByKey(...$filterByKey)->get($get);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderFilterByValue(): array
    {
        $testArrayData = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'value4', // keyが省略されているが実際には 0 => 'value4' という定義
            'value5', // keyが省略されているが実際には 1 => 'value5' という定義
            'value6', // keyが省略されているが実際には 2 => 'value6' という定義
        ];

        return [
            'invalid: 想定していないRETURN_CONDITIONを指定' => [
                'expected' => [],
                'input'    => [
                    'construct'     => new ArrayIterator($testArrayData),
                    'filterByValue' => [],
                    'get'           => '想定していないRETURN_CONDITIONを指定',
                ],
                'exception' => InvalidArgumentException::class,
            ],
            'valid: $testArrayDataのvalueに対して検索をおこない、一致した要素のkeyを取得' => [
                'expected' => [
                    // NOTE: keyのみを取得するため、返り値の添字要素は振り直される
                    0 => 'key2',
                    1 => 1,
                    2 => 2,
                ],
                'input' => [
                    'construct'     => new ArrayIterator($testArrayData),
                    'filterByValue' => ['value2', 'value5', 'value6'],
                    'get'           => ArrayOperation::RETURN_CONDITION_KEY,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのvalueに対して検索をおこない、一致した要素のvalueを取得' => [
                'expected' => [
                    // NOTE: valueのみを取得するため、返り値の添字要素は振り直される
                    0 => 'value2',
                    1 => 'value5',
                    2 => 'value6',
                ],
                'input' => [
                    'construct'     => new ArrayIterator($testArrayData),
                    'filterByValue' => ['value2', 'value5', 'value6'],
                    'get'           => ArrayOperation::RETURN_CONDITION_VALUE,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのvalueに対して検索をおこない、一致した要素のkey,valueを取得' => [
                'expected' => [
                    // NOTE: key,valueを取得するため、返り値の添字要素は維持される
                    'key2' => 'value2',
                    1      => 'value5',
                    2      => 'value6',
                ],
                'input' => [
                    'construct'     => new ArrayIterator($testArrayData),
                    'filterByValue' => ['value2', 'value5', 'value6'],
                    'get'           => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのvalueに対して検索をおこない、一致した要素のkeyを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct'     => new ArrayIterator([]),
                    'filterByValue' => ['value2', 'value5', 'value6'],
                    'get'           => ArrayOperation::RETURN_CONDITION_KEY,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのvalueに対して検索をおこない、一致した要素のvalueを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct'     => new ArrayIterator([]),
                    'filterByValue' => ['value2', 'value5', 'value6'],
                    'get'           => ArrayOperation::RETURN_CONDITION_VALUE,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのvalueに対して検索をおこない、一致した要素のkey,valueを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct'     => new ArrayIterator([]),
                    'filterByValue' => ['value2', 'value5', 'value6'],
                    'get'           => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderFilterByValue
     *
     * @param mixed $expected
     * @param mixed $input
     * @param mixed $exception
     */
    public function testFilterByValue($expected, $input, $exception): void
    {
        [
            'construct'     => $construct,
            'filterByValue' => $filterByValue,
            'get'           => $get,
        ] = $input;

        $instance = new ArrayOperation($construct);

        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $instance->filterByValue(...$filterByValue)->get($get);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderFilter(): array
    {
        $testArrayData = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'value4', // keyが省略されているが実際には 0 => 'value4' という定義
            'value5', // keyが省略されているが実際には 1 => 'value5' という定義
            'value6', // keyが省略されているが実際には 2 => 'value6' という定義
        ];

        return [
            'invalid: 想定していないSEARCH_CONDITIONを指定' => [
                'expected' => [],
                'input'    => [
                    'construct' => new ArrayIterator($testArrayData),
                    'filter'    => [
                        [],
                        '想定していないSEARCH_CONDITIONを指定',
                    ],

                    'get' => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => InvalidArgumentException::class,
            ],
            'valid: $testArrayDataのkeyに対して検索をおこない、一致した要素のkeyを取得' => [
                'expected' => [
                    'key2' => 'value2',
                    1      => 'value5',
                    2      => 'value6',
                ],
                'input' => [
                    'construct' => new ArrayIterator($testArrayData),
                    'filter'    => [
                        ['key2', 1, 2],
                        ArrayOperation::SEARCH_CONDITION_KEY,
                    ],
                    'get' => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのvalueに対して検索をおこない、一致した要素のvalueを取得' => [
                'expected' => [
                    'key2' => 'value2',
                    1      => 'value5',
                    2      => 'value6',
                ],
                'input' => [
                    'construct' => new ArrayIterator($testArrayData),
                    'filter'    => [
                        ['value2', 'value5', 'value6'],
                        ArrayOperation::SEARCH_CONDITION_VALUE,
                    ],
                    'get' => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
            'valid: $testArrayDataのkey,valueに対して検索をおこない、一致した要素のkey,valueを取得' => [
                'expected' => [
                    'key2' => 'value2',
                    1      => 'value5',
                    2      => 'value6',
                ],
                'input' => [
                    'construct' => new ArrayIterator($testArrayData),
                    'filter'    => [
                        ['key2' => 'value2', 1 => 'value5', 2 => 'value6'],
                        ArrayOperation::SEARCH_CONDITION_ELEMENT,
                    ],
                    'get' => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderFilter
     *
     * @param mixed $expected
     * @param mixed $input
     * @param mixed $exception
     */
    public function testFilter($expected, $input, $exception): void
    {
        [
            'construct' => $construct,
            'filter'    => $filter,
            'get'       => $get,
        ] = $input;

        $instance = new ArrayOperation($construct);

        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $instance->filter(...$filter)->get($get);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderGetFirst(): array
    {
        $testArrayData = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'value4', // keyが省略されているが実際には 0 => 'value4' という定義
            'value5', // keyが省略されているが実際には 1 => 'value5' という定義
            'value6', // keyが省略されているが実際には 2 => 'value6' という定義
        ];

        return [
            'invalid: 想定していないRETURN_CONDITIONを指定' => [
                'expected' => [],
                'input'    => [
                    'construct' => new ArrayIterator($testArrayData),
                    'getFirst'  => '想定していないRETURN_CONDITIONを指定',
                ],
                'exception' => InvalidArgumentException::class,
            ],
            'valid: 先頭要素のkeyを取得' => [
                'expected' => [
                    0 => 'key1',
                ],
                'input' => [
                    'construct' => new ArrayIterator($testArrayData),
                    'getFirst'  => ArrayOperation::RETURN_CONDITION_KEY,
                ],
                'exception' => null,
            ],
            'valid: 先頭要素のvalueを取得' => [
                'expected' => [
                    0 => 'value1',
                ],
                'input' => [
                    'construct' => new ArrayIterator($testArrayData),
                    'getFirst'  => ArrayOperation::RETURN_CONDITION_VALUE,
                ],
                'exception' => null,
            ],
            'valid: 先頭要素のkey,valueを取得' => [
                'expected' => [
                    'key1' => 'value1',
                ],
                'input' => [
                    'construct' => new ArrayIterator($testArrayData),
                    'getFirst'  => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
            'valid: 先頭要素のkeyを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct' => new ArrayIterator([]),
                    'getFirst'  => ArrayOperation::RETURN_CONDITION_KEY,
                ],
                'exception' => null,
            ],
            'valid: 先頭要素のvalueを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct' => new ArrayIterator([]),
                    'getFirst'  => ArrayOperation::RETURN_CONDITION_VALUE,
                ],
                'exception' => null,
            ],
            'valid: 先頭要素のkey,valueを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct' => new ArrayIterator([]),
                    'getFirst'  => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGetFirst
     *
     * @param mixed $expected
     * @param mixed $input
     * @param mixed $exception
     */
    public function testGetFirst($expected, $input, $exception): void
    {
        [
            'construct' => $construct,
            'getFirst'  => $getFirst,
        ] = $input;

        $instance = new ArrayOperation($construct);

        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $instance->getFirst($getFirst);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderGetLast(): array
    {
        $testArrayData = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'value4', // keyが省略されているが実際には 0 => 'value4' という定義
            'value5', // keyが省略されているが実際には 1 => 'value5' という定義
            'value6', // keyが省略されているが実際には 2 => 'value6' という定義
        ];

        return [
            'invalid: 想定していないRETURN_CONDITIONを指定' => [
                'expected' => [],
                'input'    => [
                    'construct' => new ArrayIterator($testArrayData),
                    'getLast'   => '想定していないRETURN_CONDITIONを指定',
                ],
                'exception' => InvalidArgumentException::class,
            ],
            'valid: 末尾要素のkeyを取得' => [
                'expected' => [
                    0 => 2,
                ],
                'input' => [
                    'construct' => new ArrayIterator($testArrayData),
                    'getLast'   => ArrayOperation::RETURN_CONDITION_KEY,
                ],
                'exception' => null,
            ],
            'valid: 末尾要素のvalueを取得' => [
                'expected' => [
                    0 => 'value6',
                ],
                'input' => [
                    'construct' => new ArrayIterator($testArrayData),
                    'getLast'   => ArrayOperation::RETURN_CONDITION_VALUE,
                ],
                'exception' => null,
            ],
            'valid: 末尾要素のkey,valueを取得' => [
                'expected' => [
                    2 => 'value6',
                ],
                'input' => [
                    'construct' => new ArrayIterator($testArrayData),
                    'getLast'   => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
            'valid: 末尾要素のkeyを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct' => new ArrayIterator([]),
                    'getLast'   => ArrayOperation::RETURN_CONDITION_KEY,
                ],
                'exception' => null,
            ],
            'valid: 末尾要素のvalueを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct' => new ArrayIterator([]),
                    'getLast'   => ArrayOperation::RETURN_CONDITION_VALUE,
                ],
                'exception' => null,
            ],
            'valid: 末尾要素のkey,valueを取得（空配列のイテレータ）' => [
                'expected' => [],
                'input'    => [
                    'construct' => new ArrayIterator([]),
                    'getLast'   => ArrayOperation::RETURN_CONDITION_ELEMENT,
                ],
                'exception' => null,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGetLast
     *
     * @param mixed $expected
     * @param mixed $input
     * @param mixed $exception
     */
    public function testGetLast($expected, $input, $exception): void
    {
        [
            'construct' => $construct,
            'getLast'   => $getLast,
        ] = $input;

        $instance = new ArrayOperation($construct);

        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $instance->getLast($getLast);
        $this->assertSame($expected, $actual);
    }
}
