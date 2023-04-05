<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Exchanger\Define;

use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Selen\Schema\Exchange\ArrayDefine;
use Selen\Schema\Exchange\Define;
use Selen\Schema\Exchange\KeyExchangeInterface;
use Selen\Schema\Exchange\ValueExchangeInterface;
use Selen\Schema\Exchanger;
use Selen\Str\Exchanger\CaseName;

/**
 * @coversDefaultClass \Selen\Schema\Exchanger
 *
 * @see \Selen\Schema\Exchanger
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
                        // keyを指定しない場合、callableの引数には配列内の要素値が渡されます
                        Define::noKey()->value(function ($value) {
                            return $value . ' + add string';
                        })
                    ),
                    'keyExchangeExecute'   => null,
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
                        Define::key(0)->value(function ($value) {
                            return $value .= ' + add string 0';
                        }),
                        Define::key('1')->value(function ($value) {
                            return $value .= ' + add string 1';
                        })
                    ),
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // key指定あり（input配列のkey名指定あり）
            'pattern003' => [
                'expected' => [
                    3         => 'value1 + add string index key = 3',
                    'keyName' => 'value2 + add string index key = keyName',
                ],
                'input' => [
                    'value' => [
                        3         => 'value1',
                        'keyName' => 'value2',
                    ],
                    'define' => new ArrayDefine(
                        Define::key(3)->value(function ($value) {
                            return $value .= ' + add string index key = 3';
                        }),
                        Define::key('keyName')->value(function ($value) {
                            return $value .= ' + add string index key = keyName';
                        })
                    ),
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // 多次元配列の変換
            'pattern004' => [
                'expected' => [
                    'keyName1'       => 'value1',
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
                        'keyName1'       => 'value1',
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
                            Define::key('childKeyName1-2')->value($valueExchangeStub1)
                        ),
                        Define::key('parentKeyName2')->arrayDefine(
                            Define::key('childKeyName2-2')->arrayDefine(
                                Define::key(1)->value($valueExchangeStub2)
                            )
                        )
                    ),
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // keyの追加
            'pattern005' => [
                'expected' => [
                    'keyName1'       => 'value1',
                    'keyName2'       => 'value2', // すでに存在する場合は処理しない
                    'parentKeyName1' => [
                        'childKeyName1-2' => 'childKeyValue1-2',
                        'childKeyName1-1' => null,
                    ],
                    'keyName3' => null,
                ],
                'input' => [
                    'value' => [
                        'keyName1'       => 'value1',
                        'keyName2'       => 'value2',
                        'parentKeyName1' => [
                            'childKeyName1-2' => 'childKeyValue1-2',
                        ],
                    ],
                    'define' => new ArrayDefine(
                        Define::key('keyName2', Define::KEY_ACTION_ADD),
                        Define::key('keyName3', Define::KEY_ACTION_ADD),
                        Define::key('parentKeyName1')->arrayDefine(
                            Define::key('childKeyName1-1', Define::KEY_ACTION_ADD)
                        )
                    ),
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // keyの削除
            'pattern006' => [
                'expected' => [
                    'keyName1'       => 'value1',
                    'parentKeyName1' => [
                        'childKeyName1-2' => 'childKeyValue1-2',
                    ],
                ],
                'input' => [
                    'value' => [
                        'keyName1'       => 'value1',
                        'keyName2'       => 'value2',
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
                    'keyExchangeExecute'   => null,
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
                        'keyName1'       => 'value1',
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
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // keyのリネーム + 変換処理
            'pattern008' => [
                'expected' => [
                    'keyName2'       => 'value2',
                    'parentKeyName1' => [
                        'childKeyName1-2'   => 'childKeyValue1-2',
                        'renameChildKey1-1' => 'replaceValue1-1',
                    ],
                    'renameKey1' => 'replaceValue1',
                ],
                'input' => [
                    'value' => [
                        'keyName1'       => 'value1',
                        'keyName2'       => 'value2',
                        'parentKeyName1' => [
                            'childKeyName1-1' => 'childKeyValue1-1',
                            'childKeyName1-2' => 'childKeyValue1-2',
                        ],
                    ],
                    'define' => new ArrayDefine(
                        Define::key('keyName1', Define::KEY_ACTION_RENAME, $keyExchangeStub1)->value(function ($value) {
                            return 'replaceValue1';
                        }),
                        Define::key('parentKeyName1')->arrayDefine(
                            Define::key('childKeyName1-1', Define::KEY_ACTION_RENAME, $keyExchangeStub2)->value(function ($value) {
                                return 'replaceValue1-1';
                            })
                        )
                    ),
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // すべてのkeyのリネーム
            'pattern009' => [
                'expected' => [
                    'key_name1'        => 'value1',
                    'key_name2'        => 'value2',
                    'parent_key_name1' => [
                        'child_key_name1_1' => 'childKeyValue1-1',
                        'child_key_name1_2' => 'childKeyValue1-2',
                    ],
                ],
                'input' => [
                    'value' => [
                        'keyName1'       => 'value1',
                        'keyName2'       => 'value2',
                        'parentKeyName1' => [
                            'childKeyName1-1' => 'childKeyValue1-1',
                            'childKeyName1-2' => 'childKeyValue1-2',
                        ],
                    ],
                    'define'             => null,
                    'keyExchangeExecute' => function ($key) {
                        return CaseName::snake($key);
                    },
                    'valueExchangeExecute' => null,
                ],
            ],
            // すべての値の置換
            'pattern010' => [
                'expected' => [
                    'keyName1'       => 'value1',
                    'keyName2'       => 'value2',
                    'parentKeyName1' => [
                        'childKeyName1-1' => 'child_key_value1_1',
                        'childKeyName1-2' => 'child_key_value1_2',
                    ],
                ],
                'input' => [
                    'value' => [
                        'keyName1'       => 'value1',
                        'keyName2'       => 'value2',
                        'parentKeyName1' => [
                            'childKeyName1-1' => 'childKeyValue1-1',
                            'childKeyName1-2' => 'childKeyValue1-2',
                        ],
                    ],
                    'define'               => null,
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => function ($value) {
                        if (\is_string($value)) {
                            return CaseName::snake($value);
                        }
                        return $value;
                    },
                ],
            ],
            /*
             * 各種変換処理をすべて組み合わせたパターン
             * - キー名を変換（すべて）
             * - 値を変換（すべて）
             * - キー名を削除（個別）
             * - キー名を追加（個別）
             * - キー名を別の名前に変換（個別）
             * - 値変換（個別）
             */
            'pattern011' => [
                'expected' => [
                    'dummy_key1'   => 'dummyValue1 add string',
                    'dummy_key2'   => 'dummyValue2 add string',
                    'dummy_key3'   => 0,
                    'dummy_key4'   => true,
                    'dummy_key5'   => [],
                    'dummy_key6'   => 0.1,
                    'created_at'   => '2022-09-05 add string',
                    'updated_at'   => 1662940800,
                    'queue_status' => 'success add string',
                    'use_state'    => false,
                ],
                'input' => [
                    'value' => [
                        'id'         => '630f1d9dc7636af90c0d73f6',
                        'dummyKey1'  => 'dummyValue1',
                        'dummyKey2'  => 'dummyValue2',
                        'dummyKey3'  => 0,
                        'dummyKey4'  => true,
                        'dummyKey5'  => [],
                        'dummyKey6'  => 0.1,
                        'queueState' => 'success',
                        'createdAt'  => new DateTime('2022-09-05'),
                        'updatedAt'  => new DateTime('2022-09-12'),
                    ],
                    'define' => new ArrayDefine(
                        // key削除
                        Define::key('id', Define::KEY_ACTION_REMOVE),
                        // keyリネーム
                        Define::key('queueState', Define::KEY_ACTION_RENAME, function ($key) {
                            return 'queueStatus';
                        }),
                        // key追加しつつ初期値を設定
                        Define::key('useState', Define::KEY_ACTION_ADD)->value(function ($value) {
                            return false;
                        }),
                        Define::key('createdAt')->value(function ($value) {
                            // @var \DateTime $value
                            return $value->format('Y-m-d');
                        }),
                        Define::key('updatedAt')->value(function ($value) {
                            // @var \DateTime $value
                            return $value->getTimestamp();
                        })
                    ),
                    'keyExchangeExecute' => function ($key) {
                        return CaseName::snake($key);
                    },
                    'valueExchangeExecute' => function ($value) {
                        if (\is_string($value)) {
                            // string型の値を持つものにはすべて接尾辞を追加
                            return $value . ' add string';
                        }
                        return $value;
                    },
                ],
            ],
            'pattern012' => [
                'expected' => [
                    'loginId' => 'user-620f1d9dc7636af90c0d73f6',
                    'linkIds' => [
                        'user-630f1d9dc7636af90c0d73f6',
                        'user-630f1d9dc7636af90c0d73f7',
                        'user-630f1d9dc7636af90c0d73f8',
                        'user-630f1d9dc7636af90c0d73f9',
                        'user-630f1d9dc7636af90c0d7400',
                    ],
                    'testKey' => [
                        'nameIds' => [
                            'user-640f1d9dc7636af90c0d73f6',
                            'user-640f1d9dc7636af90c0d73f7',
                            'user-640f1d9dc7636af90c0d73f8',
                            'user-640f1d9dc7636af90c0d73f9',
                            'user-640f1d9dc7636af90c0d7400',
                        ],
                        'uuid' => 'user-650f1d9dc7636af90c0d73f6',
                    ],
                ],
                'input' => [
                    'value' => [
                        'loginId' => '620f1d9dc7636af90c0d73f6',
                        'linkIds' => [
                            '630f1d9dc7636af90c0d73f6',
                            '630f1d9dc7636af90c0d73f7',
                            '630f1d9dc7636af90c0d73f8',
                            '630f1d9dc7636af90c0d73f9',
                            '630f1d9dc7636af90c0d7400',
                        ],
                        'testKey' => [
                            'nameIds' => [
                                '640f1d9dc7636af90c0d73f6',
                                '640f1d9dc7636af90c0d73f7',
                                '640f1d9dc7636af90c0d73f8',
                                '640f1d9dc7636af90c0d73f9',
                                '640f1d9dc7636af90c0d7400',
                            ],
                            'uuid' => '650f1d9dc7636af90c0d73f6',
                        ],
                    ],
                    'define'             => new ArrayDefine(),
                    'keyExchangeExecute' => function ($key) {
                        // keyの変換はテストしないのでそのまま返す
                        return $key;
                    },
                    'valueExchangeExecute' => function ($value) {
                        if (\is_string($value)) {
                            // string型の値を持つものにはすべて接頭辞を追加
                            return 'user-' . $value;
                        }
                        return $value;
                    },
                ],
            ],
            'pattern013' => [
                'expected' => [
                    'loginId' => '620f1d9dc7636af90c0d73f6',
                    'linkIds' => [
                        'user-630f1d9dc7636af90c0d73f6',
                        'user-630f1d9dc7636af90c0d73f7',
                        'user-630f1d9dc7636af90c0d73f8',
                        'user-630f1d9dc7636af90c0d73f9',
                        'user-630f1d9dc7636af90c0d7400',
                    ],
                ],
                'input' => [
                    'value' => [
                        'loginId' => '620f1d9dc7636af90c0d73f6',
                        'linkIds' => [
                            '630f1d9dc7636af90c0d73f6',
                            '630f1d9dc7636af90c0d73f7',
                            '630f1d9dc7636af90c0d73f8',
                            '630f1d9dc7636af90c0d73f9',
                            '630f1d9dc7636af90c0d7400',
                        ],
                    ],
                    'define' => new ArrayDefine(
                        Define::key('linkIds')->arrayDefine(
                            Define::noKey()->value(function ($value) {
                                if (\is_string($value)) {
                                    // string型の値を持つものにはすべて接頭辞を追加
                                    return 'user-' . $value;
                                }
                                return $value;
                            })
                        )
                    ),
                    'keyExchangeExecute' => function ($key) {
                        // keyの変換はテストしないのでそのまま返す
                        return $key;
                    },
                    'valueExchangeExecute' => function ($value) {
                        // valueの変換はテストしないのでそのまま返す
                        return $value;
                    },
                ],
            ],
            'pattern014' => [
                'expected' => [
                    'key2' => '620f1d9dc7636af90c0d73f6',
                    'key3' => '620f1d9dc7636af90c0d73f6',
                    // NOTE: key名を変換するexecuteがなくても（null）順番は変わる
                    'key1' => '620f1d9dc7636af90c0d73f6',
                ],
                'input' => [
                    'value' => [
                        'key1' => '620f1d9dc7636af90c0d73f6',
                        'key2' => '620f1d9dc7636af90c0d73f6',
                        'key3' => '620f1d9dc7636af90c0d73f6',
                    ],
                    'define' => new ArrayDefine(
                        // executeにnullを設定した場合、keyの変換処理は行わない
                        Define::key('key1', Define::KEY_ACTION_RENAME, null),
                        // executeにnullを設定した場合、valueの変換処理は行わない
                        Define::key('key2')->value(null),
                    ),
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            'pattern015' => [
                'expected' => [
                    'objects' => [
                        [
                            'id'   => 'prefix-ユニークID1',
                            'name' => '名前1',
                        ],
                        [
                            'id'   => 'prefix-ユニークID2',
                            'name' => '名前2',
                        ],
                        [
                            'id'   => 'prefix-ユニークID3',
                            'name' => '名前3',
                        ],
                    ],
                ],
                'input' => [
                    'value' => [
                        'objects' => [
                            [
                                'id'   => 'ユニークID1',
                                'name' => '名前1',
                            ],
                            [
                                'id'   => 'ユニークID2',
                                'name' => '名前2',
                            ],
                            [
                                'id'   => 'ユニークID3',
                                'name' => '名前3',
                            ],
                        ],
                    ],
                    'define' => new ArrayDefine(
                        Define::key('objects')->arrayDefine(
                            Define::noKey()->arrayDefine(
                                Define::key('id')->value(function ($value) {
                                    return 'prefix-' . $value;
                                })
                            )
                        ),
                    ),
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            'pattern016' => [
                'expected' => [
                    'childObject' => [
                        '_id'  => 'childObjectId',
                        'name' => '名前1',
                    ],
                    'childArrayObjects' => [
                        [
                            '_id'  => 'childArrayObjectId1',
                            'name' => '名前1',
                        ],
                        [
                            '_id'  => 'childArrayObjectId2',
                            'name' => '名前2',
                        ],
                        [
                            '_id'  => 'childArrayObjectId3',
                            'name' => '名前3',
                        ],
                    ],
                ],
                'input' => [
                    'value' => [
                        '_id'         => 'parentId',
                        'childObject' => [
                            '_id'  => 'childObjectId',
                            'name' => '名前1',
                        ],
                        'childArrayObjects' => [
                            [
                                '_id'  => 'childArrayObjectId1',
                                'name' => '名前1',
                            ],
                            [
                                '_id'  => 'childArrayObjectId2',
                                'name' => '名前2',
                            ],
                            [
                                '_id'  => 'childArrayObjectId3',
                                'name' => '名前3',
                            ],
                        ],
                    ],
                    'define' => new ArrayDefine(
                        Define::key('_id', Define::KEY_ACTION_REMOVE),
                    ),
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => null,
                ],
            ],
            // 定義側にkeyが存在し、入力側にkeyがないときのテスト
            'pattern017' => [
                'expected' => [
                    'id' => 'parentId',
                ],
                'input' => [
                    'value' => [
                        'id' => 'parentId',
                    ],
                    'define' => new ArrayDefine(
                        Define::key('key')->value(function ($value) {
                            return 'suffix-' . $value;
                        }),
                    ),
                    'keyExchangeExecute'   => null,
                    'valueExchangeExecute' => null,
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
        $define               = $input['define'];
        $keyExchangeExecute   = $input['keyExchangeExecute'];
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

    public function testKeyException()
    {
        $exchanger = Exchanger::new();
        $this->expectException(InvalidArgumentException::class);
        $exchanger->key([]);
    }

    public function testValueException()
    {
        $exchanger = Exchanger::new();
        $this->expectException(InvalidArgumentException::class);
        $exchanger->value([]);
    }
}
