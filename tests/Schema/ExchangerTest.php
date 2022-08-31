<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Exchanger\Define\Test;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Exchanger;
use Selen\Schema\Exchange\Define;
use Selen\Schema\Exchange\ArrayDefine;
use Selen\Schema\Exchange\ValueExchangeInterface;
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
                        Define::noKey()->exchange(function($values){
                            foreach($values as $key => $value){
                                $values[$key] = $value .= ' + add string';

                            }
                            return $values;
                        })
                    ),
                ]
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
                        Define::key(0)->exchange(function($value){
                            return $value .= ' + add string 0';
                        }),
                        Define::key('1')->exchange(function($value){
                            return $value .= ' + add string 1';
                        })
                    ),
                ]
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
                        Define::key(3)->exchange(function($value){
                            return $value .= ' + add string index key = 3';
                        }),
                        Define::key('keyName')->exchange(function($value){
                            return $value .= ' + add string index key = keyName';
                        })
                    ),
                ]
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
                            Define::key('childKeyName1-2')->exchange(MockCallableValueExchange::replaceString1())
                        ),
                        Define::key('parentKeyName2')->arrayDefine(
                            Define::key('childKeyName2-2')->arrayDefine(
                                Define::key(1)->exchange(new MockValueExchange())
                            )
                        )
                    ),
                ]
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

        $this->assertEquals(
            $expected,
            Exchanger::execute($value, $define));
    }
}

class MockCallableValueExchange{
    public static function replaceString1(){
        return function($value){
            return 'replace string 1';
        };
    }
}

class MockValueExchange implements ValueExchangeInterface{
    public function execute($value)
    {
        return 'replace string 2';
    }
}
