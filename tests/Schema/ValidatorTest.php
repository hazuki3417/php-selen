<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validator\Define;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\ArrayDefine;
use Selen\Schema\Validate\Define;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\Regex;
use Selen\Schema\Validate\Values\Type;
use Selen\Schema\Validator;

/**
 * @coversDefaultClass \Selen\Schema\Validator
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validator
 *
 * @see \Selen\Schema\Validator
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validator
 *
 * @internal
 *
 * TODO: input側のkeyをチェックする処理を実装する
 *       noKey()を呼び出したとき > string型のkey指定をできないようにする
 *       key()を呼び出したとき > intまたはstring型の数字をkey指定できないようにする
 *       またこれらのテストコードを実装する
 */
class ValidatorTest extends TestCase
{
    public function dataProviderValueAndExecute()
    {
        return [
            'validPattern: No validation definition' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                    ),
                    'execute' => [
                    ],
                ],
            ],
            'validPattern: [noKey()->arrayDefine()] Validation definition using class instance' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value(new Type('string'))
                    ),
                    'execute' => [
                        'target-string',
                    ],
                ],
            ],
            'validPattern: [noKey()->arrayDefine()] Validation definition using callback function' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value(function ($value, $result) {
                            // @var Selen\Schema\Validate\Model\ValidateResult $result
                            return \is_string($value) ?
                                    $result->setResult(true) :
                                    $result->setResult(false)->setMessage('Invalid type. Expected type string.');
                        })
                    ),
                    'execute' => [
                        'target-string',
                    ],
                ],
            ],
            'validPattern: [key()] Validation definition using class instance' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value(new Type('string'))
                    ),
                    'execute' => [
                        'keyName' => 'target-string',
                    ],
                ],
            ],
            'validPattern: [key()] Validation definition using callback function' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value(function ($value, $result) {
                            // @var Selen\Schema\Validate\Model\ValidateResult $result
                            return \is_string($value) ?
                                    $result->setResult(true) :
                                    $result->setResult(false)->setMessage('Invalid type. Expected type string.');
                        })
                    ),
                    'execute' => [
                        'keyName' => 'target-string',
                    ],
                ],
            ],
        ];
    }

    /**
     * テスト内容
     * - バリデーション定義なしで実行したときの挙動を確認
     * - クラスインスタンスを使ったバリデーション定義ができること
     * - コールバック関数を使ったバリデーション定義ができること
     *
     * @dataProvider dataProviderValueAndExecute
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testValueAndExecute($expected, $input)
    {
        [
            'result'          => $result,
            'validateResults' => $validateResults,
        ] = $expected;

        [
            'arrayDefine' => $arrayDefine,
            'execute'     => $execute,
        ] = $input;

        $validator    = Validator::new();
        $actualResult = $validator->arrayDefine($arrayDefine)->execute($execute);
        $this->assertValidatorClass($result, $validateResults, $actualResult);
    }

    public function dataProviderValueValidateForOneDimensionalArrayWithNoKey()
    {
        $valStr    = new Type('string');
        $valStrNum = new Regex('^[0-9]+$');

        return [
            'validPattern: No validation definition' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()
                    ),
                    'execute' => [
                        'keyName' => 'target-string',
                    ],
                ],
            ],
            'validPattern: call the value function with no arguments' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value()
                    ),
                    'execute' => [
                        'keyName' => 'target-string',
                    ],
                ],
            ],

            /**
             * 値バリデーションが1つのときのテスト
             */
            'validPattern: one value validation (one element, one type)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        'target-string',
                    ],
                ],
            ],
            'invalidPattern: one value validation (one element, one type)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[0]', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        1,
                    ],
                ],
            ],
            'validPattern: one value validation (multiple element, one type)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        'target-string1',
                        'target-string2',
                    ],
                ],
            ],

            'invalidPattern: one value validation (multiple element, one type)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[0]', 'Invalid type. Expected type string.'),
                        new ValidateResult(false, '[1]', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        1,
                        2,
                    ],
                ],
            ],
            'invalidPattern: one value validation (multiple element, multiple types)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[1]', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        'target-string1',
                        2,
                    ],
                ],
            ],

            /**
             * 値のバリデーションが複数のときのテスト
             */
            'validPattern: multiple validations (one element)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr, $valStrNum)
                    ),
                    'execute' => [
                        '12345',
                    ],
                ],
            ],
            'validPattern: multiple validations (multiple element）' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr, $valStrNum)
                    ),
                    'execute' => [
                        '12345',
                        '67890',
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - 1つめのバリデーションチェックが不合格となった場合、控えているバリデーションチェック行われないこと
             */
            'invalidPattern: multiple validations (one element, failed the first)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[0]', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr, $valStrNum)
                    ),
                    'execute' => [
                        1,
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - 配列要素分のバリデーションチェックが行われること
             *       - 1要素の中で1つめのバリデーションチェックが不合格となった場合、控えているバリデーションチェック行われないこと
             */
            'invalidPattern: multiple validations (multiple element, failed the first)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[0]', 'Invalid type. Expected type string.'),
                        new ValidateResult(false, '[1]', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr, $valStrNum)
                    ),
                    'execute' => [
                        1,
                        3,
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - 1つめのバリデーションチェックが合格となった場合、2つめのバリデーションチェックが動くこと
             */
            'invalidPattern: multiple validations (one element, failed on the second)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[0]', 'Invalid value. Expected value ^[0-9]+$.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr, $valStrNum)
                    ),
                    'execute' => [
                        '12a45',
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - 配列要素分のバリデーションチェックが行われること
             *       - 1要素の中で1つめのバリデーションチェックが合格となった場合、2つめのバリデーションチェックが動くこと
             */
            'invalidPattern: multiple validations (multiple element, failed on the second)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[0]', 'Invalid value. Expected value ^[0-9]+$.'),
                        new ValidateResult(false, '[1]', 'Invalid value. Expected value ^[0-9]+$.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr, $valStrNum)
                    ),
                    'execute' => [
                        '123a5',
                        '67b90',
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - input側で要素番号または要素名が指定されても動くこと（TODO: 仕様検討が必要）
             */
            'validPattern: Test if there is a key specification in the input array (key is int)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        1 => 'target-string',
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - input側で要素番号または要素名が指定されても動くこと（TODO: 仕様検討が必要）
             */
            'validPattern: Test if there is a key specification in the input array (key is string number)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        '1' => 'target-string',
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - input側で要素番号または要素名が指定されても動くこと（TODO: 仕様検討が必要）
             */
            'validPattern: Test if there is a key specification in the input array (key is string)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        'keyName' => 'target-string',
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - input側で要素番号または要素名が指定されても動くこと（TODO: 仕様検討が必要）
             *       - バリデーション不合格となった値のパスはinput側の値が利用されていること
             */
            'invalidPattern: Test if there is a key specification in the input array (key is int)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[1]', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        1 => true,
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - input側で要素番号または要素名が指定されても動くこと（TODO: 仕様検討が必要）
             *       - バリデーション不合格となった値のパスはinput側の値が利用されていること
             */
            'invalidPattern: Test if there is a key specification in the input array (key is string number)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[1]', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        '1' => true,
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - input側で要素番号または要素名が指定されても動くこと（TODO: 仕様検討が必要）
             *       - バリデーション不合格となった値のパスはinput側の値が利用されていること
             */
            'invalidPattern: Test if there is a key specification in the input array (key is string)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[keyName]', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value($valStr)
                    ),
                    'execute' => [
                        'keyName' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * テスト内容
     * - noKey()を使用した一次元配列の定義パターンをテスト
     *
     * @dataProvider dataProviderValueValidateForOneDimensionalArrayWithNoKey
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testValueValidateForOneDimensionalArrayWithNoKey($expected, $input)
    {
        [
            'result'          => $result,
            'validateResults' => $validateResults,
        ] = $expected;

        [
            'arrayDefine' => $arrayDefine,
            'execute'     => $execute,
        ] = $input;

        $validator    = Validator::new();
        $actualResult = $validator->arrayDefine($arrayDefine)->execute($execute);
        $this->assertValidatorClass($result, $validateResults, $actualResult);
    }

    public function dataProviderKeyValidateForOneDimensionalArrayWithKey()
    {
        return [
            /**
             * keyのバリデーションが1つのときのテスト
             */
            'validPattern: no key validation (one key)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false),
                    ),
                    'execute' => [
                        'key' => 'target-string',
                    ],
                ],
            ],
            'validPattern: with key validation (one key)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)
                    ),
                    'execute' => [
                        'keyName' => 'target-string',
                    ],
                ],
            ],
            'invalidPattern: with key validation (one key)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'key is required.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)
                    ),
                    'execute' => [
                        'key' => 'target-string',
                    ],
                ],
            ],
            /**
             * keyのバリデーションが複数のときのテスト
             */
            'validPattern: do not verify multiple keys (multiple key)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName1', false),
                        Define::key('keyName2', false),
                    ),
                    'execute' => [
                        'key1' => 'target-string',
                        'key2' => 'target-string',
                    ],
                ],
            ],
            'validPattern: Validate multiple keys (multiple key)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName1', true),
                        Define::key('keyName2', true),
                    ),
                    'execute' => [
                        'keyName1' => 'target-string',
                        'keyName2' => 'target-string',
                    ],
                ],
            ],
            'invalidPattern: Validate multiple keys (multiple key)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName1', 'key is required.'),
                        new ValidateResult(false, 'keyName2', 'key is required.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName1', true),
                        Define::key('keyName2', true),
                    ),
                    'execute' => [
                        'key1' => 'target-string',
                        'key2' => 'target-string',
                    ],
                ],
            ],
            /**
             * keyのバリデーションが混在するときのテスト
             */
            'invalidPattern: Mixed with and without key verification (multiple key)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName2', 'key is required.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName1', false),
                        Define::key('keyName2', true),
                    ),
                    'execute' => [
                        'key1' => 'target-string',
                        'key2' => 'target-string',
                    ],
                ],
            ],
        ];
    }

    /**
     * テスト内容
     * - key()を使用した一次元配列の定義パターンをテスト
     * - keyバリデーションのみの組み合わせテスト
     *
     * @dataProvider dataProviderKeyValidateForOneDimensionalArrayWithKey
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testKeyValidateForOneDimensionalArrayWithKey($expected, $input)
    {
        [
            'result'          => $result,
            'validateResults' => $validateResults,
        ] = $expected;

        [
            'arrayDefine' => $arrayDefine,
            'execute'     => $execute,
        ] = $input;

        $validator    = Validator::new();
        $actualResult = $validator->arrayDefine($arrayDefine)->execute($execute);
        $this->assertValidatorClass($result, $validateResults, $actualResult);
    }

    public function dataProviderKeyValueValidateForOneDimensionalArrayWithKey()
    {
        $valStr    = new Type('string');
        $valStrNum = new Regex('^[0-9]+$');

        return [
            /**
             * key・valueのバリデーションが混在するときのテスト
             */
            'validPattern: no validate (one key)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->value(),
                    ),
                    'execute' => [
                        'keyName' => 'target-string',
                    ],
                ],
            ],
            'validPattern: key only validate (one key)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value()
                    ),
                    'execute' => [
                        'keyName' => 'target-string',
                    ],
                ],
            ],
            'invalidPattern: key only validate (one key)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'key is required.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value()
                    ),
                    'execute' => [
                        'key' => 'target-string',
                    ],
                ],
            ],
            // NOTE: keyがoptional指定で、入力側に存在しないときは値バリデーションが実施されないことを確認
            'validPattern: value only validate (one key, input key does not match definition)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->value($valStr)
                    ),
                    'execute' => [
                        'key' => 1,
                    ],
                ],
            ],
            // NOTE: keyがoptional指定で入力側に存在するときは値バリデーションが実施されることを確認
            'validPattern: value only validate (one key, input key matches definition)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->value($valStr)
                    ),
                    'execute' => [
                        'keyName' => 'target-string',
                    ],
                ],
            ],
            // NOTE: keyがoptional指定で入力側に存在するときは値バリデーションが実施されることを確認
            'invalidPattern: value only validate (one key, input key matches definition)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->value($valStr)
                    ),
                    'execute' => [
                        'keyName' => 1,
                    ],
                ],
            ],
            // NOTE: keyがrequired指定で、入力側に存在しないときは値バリデーションが実施されないことを確認
            'invalidPattern: key and value validate (one key, input key does not match definition)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'key is required.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value($valStr)
                    ),
                    'execute' => [
                        'key' => 1,
                    ],
                ],
            ],
            // NOTE: keyがrequired指定で入力側に存在するときは値バリデーションが実施されることを確認
            'validPattern: key and value validate (one key, input key matches definition)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value($valStr)
                    ),
                    'execute' => [
                        'keyName' => 'target-string',
                    ],
                ],
            ],
            // NOTE: keyがrequired指定で入力側に存在するときは値バリデーションが実施されることを確認
            'invalidPattern: key and value validate (one key, input key matches definition)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value($valStr)
                    ),
                    'execute' => [
                        'keyName' => 1,
                    ],
                ],
            ],
            /**
             * 値のバリデーションが複数のときのテスト
             */
            'validPattern: key and value validate (one key, multiple validations)' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value($valStr, $valStrNum)
                    ),
                    'execute' => [
                        'keyName' => '12345',
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - 1つめのバリデーションチェックが不合格となった場合、控えているバリデーションチェック行われないこと
             */
            'invalidPattern: key and value validate (one key, multiple validations, failed the first)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'Invalid type. Expected type string.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value($valStr, $valStrNum)
                    ),
                    'execute' => [
                        'keyName' => 1,
                    ],
                ],
            ],
            /**
             * NOTE: 下記の内容を確認
             *       - 1つめのバリデーションチェックが合格となった場合、2つめのバリデーションチェックが動くこと
             */
            'invalidPattern: key and value validate (one key, multiple validations, failed on the second)' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'Invalid value. Expected value ^[0-9]+$.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value($valStr, $valStrNum)
                    ),
                    'execute' => [
                        'keyName' => '12a45',
                    ],
                ],
            ],
            // TODO: 複数キー指定したときのテストケースを追加する
        ];
    }

    /**
     * テスト内容
     * - key()を使用した一次元配列の定義パターンをテスト
     * - key＿valueバリデーションの組み合わせテスト
     *
     * @dataProvider dataProviderKeyValueValidateForOneDimensionalArrayWithKey
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testKeyValueValidateForOneDimensionalArrayWithKey($expected, $input)
    {
        [
            'result'          => $result,
            'validateResults' => $validateResults,
        ] = $expected;

        [
            'arrayDefine' => $arrayDefine,
            'execute'     => $execute,
        ] = $input;

        $validator    = Validator::new();
        $actualResult = $validator->arrayDefine($arrayDefine)->execute($execute);
        $this->assertValidatorClass($result, $validateResults, $actualResult);
    }

    public function dataProviderDefinesNestedArrays()
    {
        return [
            /**
             * 要素配列定義に->arrayDefine()を呼び出したときの動作を確認する
             */
            'validPattern: [noKey()->arrayDefine()] no data' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->arrayDefine()
                    ),
                    'execute' => [
                    ],
                ],
            ],
            'validPattern: [noKey()->arrayDefine()] one element, value type is array' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                    ],
                ],
            ],
            'invalidPattern: [noKey()->arrayDefine()] one element, value type is string' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[0]', 'Invalid value. Expecting a value of array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->arrayDefine()
                    ),
                    'execute' => [
                        '',
                    ],
                ],
            ],
            'invalidPattern: [noKey()->arrayDefine()] one element, key is assoc array type' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[index]', 'Invalid key. Expecting indexed array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->arrayDefine()
                    ),
                    'execute' => [
                        'index' => [],
                    ],
                ],
            ],
            'validPattern: [noKey()->arrayDefine()] multiple elements, value type is array' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                        [],
                    ],
                ],
            ],
            'invalidPattern: [noKey()->arrayDefine()] multiple element, value type is array and string' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[1]', 'Invalid value. Expecting a value of array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                        '',
                    ],
                ],
            ],
            'invalidPattern: [noKey()->arrayDefine()] multiple element, key is index and assoc type' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[index2]', 'Invalid key. Expecting indexed array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                        'index2' => [],
                    ],
                ],
            ],
            'invalidPattern: [noKey()->arrayDefine()] multiple element, key is index and assoc type, value is string and array type' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        // key指定が不正
                        new ValidateResult(false, '[index1]', 'Invalid key. Expecting indexed array type.'),
                        // value指定が不正
                        new ValidateResult(false, '[1]', 'Invalid value. Expecting a value of array type.'),
                        // key・value指定が不正
                        new ValidateResult(false, '[index2]', 'Invalid key. Expecting indexed array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                        'index1' => [],
                        '',
                        'index2' => '',
                    ],
                ],
            ],
            'validPattern: [noKey()->value()->arrayDefine()] one element, value type is array' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                    ],
                ],
            ],
            'invalidPattern: [noKey()->value()->arrayDefine()] one element, value type is string' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[0]', 'Invalid value. Expecting a value of array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value()->arrayDefine()
                    ),
                    'execute' => [
                        '',
                    ],
                ],
            ],
            'invalidPattern: [noKey()->value()->arrayDefine()] one element, key is assoc array type' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[index]', 'Invalid key. Expecting indexed array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value()->arrayDefine()
                    ),
                    'execute' => [
                        'index' => [],
                    ],
                ],
            ],
            'validPattern: [noKey()->value()->arrayDefine()] multiple elements, value type is array' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                        [],
                    ],
                ],
            ],
            'invalidPattern: [noKey()->value()->arrayDefine()] multiple element, value type is array and string' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[1]', 'Invalid value. Expecting a value of array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                        '',
                    ],
                ],
            ],
            'invalidPattern: [noKey()->value()->arrayDefine()] multiple element, key is index and assoc type' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, '[index2]', 'Invalid key. Expecting indexed array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                        'index2' => [],
                    ],
                ],
            ],
            'invalidPattern: [noKey()->value()->arrayDefine()] multiple element, key is index and assoc type, value is string and array type' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        // key指定が不正
                        new ValidateResult(false, '[index1]', 'Invalid key. Expecting indexed array type.'),
                        // value指定が不正
                        new ValidateResult(false, '[1]', 'Invalid value. Expecting a value of array type.'),
                        // key・value指定が不正
                        new ValidateResult(false, '[index2]', 'Invalid key. Expecting indexed array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::noKey()->value()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                        'index1' => [],
                        '',
                        'index2' => '',
                    ],
                ],
            ],
            /**
             * 連想配列定義に->arrayDefine()を呼び出したときの動作を確認する
             */
            'validPattern: [key()->arrayDefine()] no data' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->arrayDefine()
                    ),
                    'execute' => [
                    ],
                ],
            ],

            'validPattern: [key()->arrayDefine()] key optional, no value matches key' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->arrayDefine()
                    ),
                    'execute' => [
                        [],
                    ],
                ],
            ],
            'validPattern: [key()->arrayDefine()] key optional, key has matching value, value is array' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->arrayDefine()
                    ),
                    'execute' => [
                        'keyName' => [],
                    ],
                ],
            ],
            'invalidPattern: [key()->arrayDefine()] key optional, key has matching value, value is string' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'Invalid value. Expecting a value of array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->arrayDefine()
                    ),
                    'execute' => [
                        'keyName' => '',
                    ],
                ],
            ],
            'invalidPattern: [key()->arrayDefine()] key required, no value matches key' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'key is required.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->arrayDefine()
                    ),
                    'execute' => [
                        [],
                    ],
                ],
            ],
            'validPattern: [key()->arrayDefine()] key required, key has matching value, value is array' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->arrayDefine()
                    ),
                    'execute' => [
                        'keyName' => [],
                    ],
                ],
            ],
            'invalidPattern: [key()->arrayDefine()] key required, key has matching value, value is string' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'Invalid value. Expecting a value of array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->arrayDefine()
                    ),
                    'execute' => [
                        'keyName' => '',
                    ],
                ],
            ],
            'validPattern: [key()->value()->arrayDefine()] no data' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->value()->arrayDefine()
                    ),
                    'execute' => [
                    ],
                ],
            ],

            'validPattern: [key()->value()->arrayDefine()] key optional, no value matches key' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->value()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                    ],
                ],
            ],
            'validPattern: [key()->value()->arrayDefine()] key optional, key has matching value, value is array' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->value()->arrayDefine()
                    ),
                    'execute' => [
                        'keyName' => [],
                    ],
                ],
            ],
            'invalidPattern: [key()->value()->arrayDefine()] key optional, key has matching value, value is string' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'Invalid value. Expecting a value of array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', false)->value()->arrayDefine()
                    ),
                    'execute' => [
                        'keyName' => '',
                    ],
                ],
            ],
            'invalidPattern: [key()->value()->arrayDefine()] key required, no value matches key' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'key is required.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value()->arrayDefine()
                    ),
                    'execute' => [
                        [],
                    ],
                ],
            ],
            'validPattern: [key()->value()->arrayDefine()] key required, key has matching value, value is array' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value()->arrayDefine()
                    ),
                    'execute' => [
                        'keyName' => [],
                    ],
                ],
            ],
            'invalidPattern: [key()->value()->arrayDefine()] key required, key has matching value, value is string' => [
                'expected' => [
                    'result'          => false,
                    'validateResults' => [
                        new ValidateResult(false, 'keyName', 'Invalid value. Expecting a value of array type.'),
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                        Define::key('keyName', true)->value()->arrayDefine()
                    ),
                    'execute' => [
                        'keyName' => '',
                    ],
                ],
            ],
        ];
    }

    /**
     * テスト内容
     * - 配列をネストして定義するパターンをテスト
     *
     * @dataProvider dataProviderDefinesNestedArrays
     *
     * @group verify
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testDefinesNestedArrays($expected, $input)
    {
        [
            'result'          => $result,
            'validateResults' => $validateResults,
        ] = $expected;

        [
            'arrayDefine' => $arrayDefine,
            'execute'     => $execute,
        ] = $input;

        $validator    = Validator::new();
        $actualResult = $validator->arrayDefine($arrayDefine)->execute($execute);
        $this->assertValidatorClass($result, $validateResults, $actualResult);
    }

    public function dataProviderCombinedOfIndexArrayAndIndexArray()
    {
        $valStr    = new Type('string');
        $valStrNum = new Regex('^[0-9]+$');

        return [
            'validPattern: ' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                    ),
                    'execute' => [
                    ],
                ],
            ],
        ];
    }

    /**
     * テスト内容
     * - 要素配列に要素配列をネストする定義パターンをテスト
     *
     * @dataProvider dataProviderCombinedOfIndexArrayAndIndexArray
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testCombinedOfIndexArrayAndIndexArray($expected, $input)
    {
        [
            'result'          => $result,
            'validateResults' => $validateResults,
        ] = $expected;

        [
            'arrayDefine' => $arrayDefine,
            'execute'     => $execute,
        ] = $input;

        $validator    = Validator::new();
        $actualResult = $validator->arrayDefine($arrayDefine)->execute($execute);
        $this->assertValidatorClass($result, $validateResults, $actualResult);
    }

    public function dataProviderCombinedOfIndexArrayAndAssocArray()
    {
        $valStr    = new Type('string');
        $valStrNum = new Regex('^[0-9]+$');

        return [
            'validPattern: ' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                    ),
                    'execute' => [
                    ],
                ],
            ],
        ];
    }

    /**
     * テスト内容
     * - 要素配列に連想配列をネストする定義パターンをテスト
     *
     * @dataProvider dataProviderCombinedOfIndexArrayAndAssocArray
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testCombinedOfIndexArrayAndAssocArray($expected, $input)
    {
        [
            'result'          => $result,
            'validateResults' => $validateResults,
        ] = $expected;

        [
            'arrayDefine' => $arrayDefine,
            'execute'     => $execute,
        ] = $input;

        $validator    = Validator::new();
        $actualResult = $validator->arrayDefine($arrayDefine)->execute($execute);
        $this->assertValidatorClass($result, $validateResults, $actualResult);
    }

    public function dataProviderCombinedOfAssocArrayAndAssocArray()
    {
        $valStr    = new Type('string');
        $valStrNum = new Regex('^[0-9]+$');

        return [
            'validPattern: ' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                    ),
                    'execute' => [
                    ],
                ],
            ],
        ];
    }

    /**
     * テスト内容
     * - 連想配列に連想配列をネストする定義パターンをテスト
     *
     * @dataProvider dataProviderCombinedOfAssocArrayAndAssocArray
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testCombinedOfAssocArrayAndAssocArray($expected, $input)
    {
        [
            'result'          => $result,
            'validateResults' => $validateResults,
        ] = $expected;

        [
            'arrayDefine' => $arrayDefine,
            'execute'     => $execute,
        ] = $input;

        $validator    = Validator::new();
        $actualResult = $validator->arrayDefine($arrayDefine)->execute($execute);
        $this->assertValidatorClass($result, $validateResults, $actualResult);
    }

    public function dataProviderCombinedOfAssocArrayAndIndexArray()
    {
        $valStr    = new Type('string');
        $valStrNum = new Regex('^[0-9]+$');

        return [
            'validPattern: ' => [
                'expected' => [
                    'result'          => true,
                    'validateResults' => [
                    ],
                ],
                'input' => [
                    'arrayDefine' => new ArrayDefine(
                    ),
                    'execute' => [
                    ],
                ],
            ],
        ];
    }

    /**
     * テスト内容
     * - 連想配列に要素配列をネストする定義パターンをテスト
     *
     * @dataProvider dataProviderCombinedOfAssocArrayAndIndexArray
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testCombinedOfAssocArrayAndIndexArray($expected, $input)
    {
        [
            'result'          => $result,
            'validateResults' => $validateResults,
        ] = $expected;

        [
            'arrayDefine' => $arrayDefine,
            'execute'     => $execute,
        ] = $input;

        $validator    = Validator::new();
        $actualResult = $validator->arrayDefine($arrayDefine)->execute($execute);
        $this->assertValidatorClass($result, $validateResults, $actualResult);
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
