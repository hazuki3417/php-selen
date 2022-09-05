<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Exchanger\Define\Test;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Exchange\ArrayDefine;
use Selen\Schema\Exchange\Define;
use Selen\Schema\Exchange\KeyExchangeInterface;
use Selen\Schema\Exchange\ValueExchangeInterface;
use Selen\Schema\Exchanger;
use Selen\Str\CaseName;

/**
 * @coversDefaultClass \Selen\Schema\Exchanger
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Exchanger
 *
 * @see \Selen\Schema\Exchanger
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Exchanger
 *
 * @internal
 */
class ExchangerTest extends TestCase
{
    public function dataProviderExecute()
    {
        $valueExchangeStub1 = function ($value) {
            return 'replace string 1';
        };
        $valueExchangeStub2 = $this->createStub(ValueExchangeInterface::class);
        $valueExchangeStub2->method('execute')->willReturn('replace string 2');

        $keyExchangeStub1 = function ($value) {
            return 'renameKey1';
        };
        $keyExchangeStub2 = $this->createStub(KeyExchangeInterface::class);
        $keyExchangeStub2->method('execute')->willReturn('renameChildKey1-1');

        return [
            // key指定なし
            'pattern001' => [
                'expected' => [
                    'value1 + add string',
                    'value2 + add string',
                ],
                'input' => [
                    'value' => [
                        'value1',
                        'value2',
                    ],
                    'define' => new ArrayDefine(
                        // keyを指定しない場合、callableの引数には配列がそのまま渡されます
                        Define::noKey()->exchange(function ($values) {
                            foreach ($values as $key => $value) {
                                $values[$key] = $value .= ' + add string';
                            }
                            return $values;
                        })
                    ),
                    'keyExchangeExecute' => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // key指定あり（input配列のkey名指定なし）
            'pattern002' => [
                'expected' => [
                    'value1 + add string 0',
                    'value2 + add string 1',
                ],
                'input' => [
                    'value' => [
                        'value1',
                        'value2',
                    ],
                    'define' => new ArrayDefine(
                        // keyを指定した場合、callableの引数にはkey名に対応する値が渡されます
                        // key名にindexを指定した場合は配列が持っているindexを参照します
                        // int型の0とstring型の'0'は同じindexとして扱います（php配列の仕様）
                        Define::key(0)->exchange(function ($value) {
                            return $value .= ' + add string 0';
                        }),
                        Define::key('1')->exchange(function ($value) {
                            return $value .= ' + add string 1';
                        })
                    ),
                    'keyExchangeExecute' => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // key指定あり（input配列のkey名指定あり）
            'pattern003' => [
                'expected' => [
                    3 => 'value1 + add string index key = 3',
                    'keyName' => 'value2 + add string index key = keyName',
                ],
                'input' => [
                    'value' => [
                        3 => 'value1',
                        'keyName' => 'value2',
                    ],
                    'define' => new ArrayDefine(
                        Define::key(3)->exchange(function ($value) {
                            return $value .= ' + add string index key = 3';
                        }),
                        Define::key('keyName')->exchange(function ($value) {
                            return $value .= ' + add string index key = keyName';
                        })
                    ),
                    'keyExchangeExecute' => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // 多次元配列の変換
            'pattern004' => [
                'expected' => [
                    'keyName1' => 'value1',
                    'parentKeyName1' => [
                        'childKeyName1-1' => 'childKeyValue1-1',
                        'childKeyName1-2' => 'replace string 1',
                    ],
                    'parentKeyName2' => [
                        'childKeyName2-1' => 'childKeyValue2-1',
                        'childKeyName2-2' => [
                            'childKeyValue2-2-0',
                            'replace string 2',
                            'childKeyValue2-2-2',
                        ],
                    ],
                ],
                'input' => [
                    'value' => [
                        'keyName1' => 'value1',
                        'parentKeyName1' => [
                            'childKeyName1-1' => 'childKeyValue1-1',
                            'childKeyName1-2' => 'childKeyValue1-2',
                        ],
                        'parentKeyName2' => [
                            'childKeyName2-1' => 'childKeyValue2-1',
                            'childKeyName2-2' => [
                                'childKeyValue2-2-0',
                                'childKeyValue2-2-1',
                                'childKeyValue2-2-2',
                            ],
                        ],
                    ],
                    'define' => new ArrayDefine(
                        Define::key('parentKeyName1')->arrayDefine(
                            Define::key('childKeyName1-2')->exchange($valueExchangeStub1)
                        ),
                        Define::key('parentKeyName2')->arrayDefine(
                            Define::key('childKeyName2-2')->arrayDefine(
                                Define::key(1)->exchange($valueExchangeStub2)
                            )
                        )
                    ),
                    'keyExchangeExecute' => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // keyの追加
            'pattern005' => [
                'expected' => [
                    'keyName1' => 'value1',
                    'parentKeyName1' => [
                        'childKeyName1-2' => 'childKeyValue1-2',
                        'childKeyName1-1' => null,
                    ],
                    'keyName2' => null,
                ],
                'input' => [
                    'value' => [
                        'keyName1' => 'value1',
                        'parentKeyName1' => [
                            'childKeyName1-2' => 'childKeyValue1-2',
                        ],
                    ],
                    'define' => new ArrayDefine(
                        Define::key('keyName2', Define::KEY_ACTION_ADD),
                        Define::key('parentKeyName1')->arrayDefine(
                            Define::key('childKeyName1-1', Define::KEY_ACTION_ADD)
                        )
                    ),
                    'keyExchangeExecute' => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // keyの削除
            'pattern006' => [
                'expected' => [
                    'keyName1' => 'value1',
                    'parentKeyName1' => [
                        'childKeyName1-2' => 'childKeyValue1-2',
                    ],
                ],
                'input' => [
                    'value' => [
                        'keyName1' => 'value1',
                        'keyName2' => 'value2',
                        'parentKeyName1' => [
                            'childKeyName1-1' => 'childKeyValue1-1',
                            'childKeyName1-2' => 'childKeyValue1-2',
                        ],
                    ],
                    'define' => new ArrayDefine(
                        Define::key('keyName2', Define::KEY_ACTION_REMOVE),
                        Define::key('parentKeyName1')->arrayDefine(
                            Define::key('childKeyName1-1', Define::KEY_ACTION_REMOVE)
                        )
                    ),
                    'keyExchangeExecute' => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // keyのリネーム
            'pattern007' => [
                'expected' => [
                    // keyの順番は保証しない・サポートもしない
                    'parentKeyName1' => [
                        'renameChildKey1-1' => 'childKeyValue1-1',
                    ],
                    'renameKey1' => 'value1',
                ],
                'input' => [
                    'value' => [
                        'keyName1' => 'value1',
                        'parentKeyName1' => [
                            'childKeyName1-1' => 'childKeyValue1-1',
                        ],
                    ],
                    'define' => new ArrayDefine(
                        Define::key('keyName1', Define::KEY_ACTION_RENAME, function ($keyName) {
                            return 'renameKey1';
                        }),
                        Define::key('parentKeyName1')->arrayDefine(
                            Define::key('childKeyName1-1', Define::KEY_ACTION_RENAME, function ($keyName) {
                                return 'renameChildKey1-1';
                            })
                        )
                    ),
                    'keyExchangeExecute' => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // keyのリネーム + 変換処理
            'pattern008' => [
                'expected' => [
                    'keyName2' => 'value2',
                    'parentKeyName1' => [
                        'childKeyName1-2' => 'childKeyValue1-2',
                        'renameChildKey1-1' => 'replaceValue1-1',
                    ],
                    'renameKey1' => 'replaceValue1',
                ],
                'input' => [
                    'value' => [
                        'keyName1' => 'value1',
                        'keyName2' => 'value2',
                        'parentKeyName1' => [
                            'childKeyName1-1' => 'childKeyValue1-1',
                            'childKeyName1-2' => 'childKeyValue1-2',
                        ],
                    ],
                    'define' => new ArrayDefine(
                        Define::key('keyName1', Define::KEY_ACTION_RENAME, $keyExchangeStub1)->exchange(function ($value) {
                            return 'replaceValue1';
                        }),
                        Define::key('parentKeyName1')->arrayDefine(
                            Define::key('childKeyName1-1', Define::KEY_ACTION_RENAME, $keyExchangeStub2)->exchange(function ($value) {
                                return 'replaceValue1-1';
                            })
                        )
                    ),
                    'keyExchangeExecute' => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // すべてのkeyのリネーム
            'pattern009' => [
                'expected' => [
                    'key_name1' => 'value1',
                    'key_name2' => 'value2',
                    'parent_key_name1' => [
                        'child_key_name1_1' => 'childKeyValue1-1',
                        'child_key_name1_2' => 'childKeyValue1-2',
                    ],
                ],
                'input' => [
                    'value' => [
                        'keyName1' => 'value1',
                        'keyName2' => 'value2',
                        'parentKeyName1' => [
                            'childKeyName1-1' => 'childKeyValue1-1',
                            'childKeyName1-2' => 'childKeyValue1-2',
                        ],
                    ],
                    'define' => null,
                    'keyExchangeExecute' => function ($key) {
                        return CaseName::snake($key);
                    },
                    'valueExchangeExecute' => null,
                ],
            ],
            // すべての値の置換
            'pattern010' => [
                'expected' => [
                    'keyName1' => 'value1',
                    'keyName2' => 'value2',
                    'parentKeyName1' => [
                        'childKeyName1-1' => 'child_key_value1_1',
                        'childKeyName1-2' => 'child_key_value1_2',
                    ],
                ],
                'input' => [
                    'value' => [
                        'keyName1' => 'value1',
                        'keyName2' => 'value2',
                        'parentKeyName1' => [
                            'childKeyName1-1' => 'childKeyValue1-1',
                            'childKeyName1-2' => 'childKeyValue1-2',
                        ],
                    ],
                    'define' => null,
                    'keyExchangeExecute' => null,
                    'valueExchangeExecute' => function ($value) {
                        if (\is_string($value)) {
                            return CaseName::snake($value);
                        }
                        return $value;
                    },
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testExecute($expected, $input)
    {
        /** @var array $value */
        $value = $input['value'];
        /** @var \Selen\Schema\Exchange\ArrayDefine $define */
        $define = $input['define'];
        $keyExchangeExecute = $input['keyExchangeExecute'];
        $valueExchangeExecute = $input['valueExchangeExecute'];

        $exchanger = Exchanger::new();

        $this->assertSame(
            $expected,
            $exchanger
                ->key($keyExchangeExecute)
                ->value($valueExchangeExecute)
                ->arrayDefine($define)
                ->execute($value)
        );
    }
}
