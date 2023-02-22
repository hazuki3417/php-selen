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
use Selen\Schema\Validate\Values\Type;
use Selen\Schema\Validate\ValueValidateInterface;
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
 */
class ValidatorTest extends TestCase
{
    /**
     * NOTE: 入力値と期待値の定義が複雑なため、メソッド単位でテストパターンを記載
     *       dataProviderを使うと可読性が下がるため
     */

    /**
     * keyのバリデーションテスト（1次元配列）
     */
    public function testPattern000()
    {
        $expectedSuccess         = false;
        $expectedValidateResults = [
            new ValidateResult(false, 'key1', 'key is required.'),
            new ValidateResult(false, 'key2', 'key is required.'),
        ];

        $define = new ArrayDefine(
            Define::key('key1', true),
            Define::key('key2', true),
            Define::key('key3', false),
            Define::key('key4', false)
        );

        $input = [];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * keyのバリデーションテスト（1次元配列）
     */
    public function testPattern001()
    {
        $expectedSuccess         = true;
        $expectedValidateResults = [
        ];

        $define = new ArrayDefine(
            Define::key('key1', true),
            Define::key('key2', true),
            Define::key('key3', false),
            Define::key('key4', false)
        );

        $input = [
            'key1' => '0',
            'key2' => '0',
            'key3' => '0',
            // 'key4' => '0',
        ];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * keyのバリデーションテスト（多次元配列）
     *
     * @param mixed $expectedSuccess
     * @param mixed $expectedValidateResults
     * @param mixed $result
     */
    public function testPattern010()
    {
        $expectedSuccess         = false;
        $expectedValidateResults = [
            // NOTE: コメントアウトされた行は記録されない想定の検証結果
            new ValidateResult(false, 'key1', 'key is required.'),
            new ValidateResult(false, 'key1.key1-1', 'key is required.'),
            new ValidateResult(false, 'key1.key1-1.key1-1-1', 'key is required.'),
            new ValidateResult(false, 'key1.key1-1.key1-1-3', 'key is required.'),

            new ValidateResult(false, 'key2.key2-1', 'key is required.'),
            new ValidateResult(false, 'key2.key2-1.key2-1-1', 'key is required.'),
            new ValidateResult(false, 'key2.key2-1.key2-1-3', 'key is required.'),

            new ValidateResult(false, 'key3.key3-1.key3-1-1', 'key is required.'),
            new ValidateResult(false, 'key3.key3-1.key3-1-3', 'key is required.'),

            new ValidateResult(false, 'key4', 'key is required.'),
            new ValidateResult(false, 'key4.[0].key4-1-1', 'key is required.'),
            new ValidateResult(false, 'key4.[0].key4-1-3', 'key is required.'),

            new ValidateResult(false, 'key5.[0].key5-1-1', 'key is required.'),
            new ValidateResult(false, 'key5.[0].key5-1-3', 'key is required.'),
        ];

        $define = new ArrayDefine(
            Define::key('key1', true)->arrayDefine(
                Define::key('key1-1', true)->arrayDefine(
                    Define::key('key1-1-1', true),
                    Define::key('key1-1-2', false),
                    Define::key('key1-1-3', true)
                )
            ),
            Define::key('key2', false)->arrayDefine(
                Define::key('key2-1', true)->arrayDefine(
                    Define::key('key2-1-1', true),
                    Define::key('key2-1-2', false),
                    Define::key('key2-1-3', true)
                )
            ),
            Define::key('key3', false)->arrayDefine(
                Define::key('key3-1', false)->arrayDefine(
                    Define::key('key3-1-1', true),
                    Define::key('key3-1-2', false),
                    Define::key('key3-1-3', true)
                )
            ),
            Define::key('key4', true)->arrayDefine(
                Define::noKey()->arrayDefine(
                    Define::key('key4-1-1', true),
                    Define::key('key4-1-2', false),
                    Define::key('key4-1-3', true)
                )
            ),
            Define::key('key5', false)->arrayDefine(
                Define::noKey()->arrayDefine(
                    Define::key('key5-1-1', true),
                    Define::key('key5-1-2', false),
                    Define::key('key5-1-3', true)
                )
            )
        );

        $input = [];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * keyのバリデーションテスト（多次元配列）
     *
     * @param mixed $expectedSuccess
     * @param mixed $expectedValidateResults
     * @param mixed $result
     */
    public function testPattern011()
    {
        $expectedSuccess         = true;
        $expectedValidateResults = [
        ];

        $define = new ArrayDefine(
            Define::key('key1', true)->arrayDefine(
                Define::key('key1-1', true)->arrayDefine(
                    Define::key('key1-1-1', true),
                    Define::key('key1-1-2', false),
                    Define::key('key1-1-3', true)
                )
            ),
            Define::key('key2', false)->arrayDefine(
                Define::key('key2-1', true)->arrayDefine(
                    Define::key('key2-1-1', true),
                    Define::key('key2-1-2', false),
                    Define::key('key2-1-3', true)
                )
            ),
            Define::key('key3', false)->arrayDefine(
                Define::key('key3-1', false)->arrayDefine(
                    Define::key('key3-1-1', true),
                    Define::key('key3-1-2', false),
                    Define::key('key3-1-3', true)
                )
            ),
            Define::key('key4', true)->arrayDefine(
                Define::noKey()->arrayDefine(
                    Define::key('key4-1-1', true),
                    Define::key('key4-1-2', false),
                    Define::key('key4-1-3', true)
                )
            ),
            Define::key('key5', false)->arrayDefine(
                Define::noKey()->arrayDefine(
                    Define::key('key5-1-1', true),
                    Define::key('key5-1-2', false),
                    Define::key('key5-1-3', true)
                )
            )
        );

        $input = [
            'key1' => [
                'key1-1' => [
                    'key1-1-1' => 0,
                    'key1-1-2' => 0,
                    'key1-1-3' => 0,
                ],
            ],
            'key2' => [
                'key2-1' => [
                    'key2-1-1' => 0,
                    'key2-1-3' => 0,
                ],
            ],
            'key3' => [
                'key3-1' => [
                    'key3-1-1' => 0,
                    'key3-1-2' => 0,
                    'key3-1-3' => 0,
                ],
            ],
            'key4' => [
                [
                    'key4-1-1' => 0,
                    'key4-1-3' => 0,
                ],
                [
                    'key4-1-1' => 0,
                    'key4-1-3' => 0,
                ],
            ],
            'key5' => [
                [
                    'key5-1-1' => 0,
                    'key5-1-2' => 0,
                    'key5-1-3' => 0,
                ],
            ],
        ];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * 値のバリデーションテスト（1次元配列）
     */
    public function testPattern100()
    {
        $expectedSuccess         = false;
        $expectedValidateResults = [
            new ValidateResult(false, 'key2', 'Invalid value type. Expected string type.'),
            new ValidateResult(false, 'key4', 'Invalid value type. Expected string type.'),
        ];

        $callableIsString = function ($value, $result) {
            // @var Selen\Schema\Validate\Model\ValidateResult $result
            return \is_string($value) ?
                    $result->setResult(true) :
                    $result->setResult(false)->setMessage('Invalid value type. Expected string type.');
        };

        $define = new ArrayDefine(
            Define::key('key1', true)->value($callableIsString),
            Define::key('key2', true)->value($callableIsString),
            Define::key('key3', false)->value($callableIsString),
            Define::key('key4', false)->value($callableIsString)
        );

        $input = [
            'key1' => 'string',
            'key2' => 0,
            'key3' => 'string',
            'key4' => 0,
        ];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * 値のバリデーションテスト（1次元配列）
     */
    public function testPattern101()
    {
        $expectedSuccess         = false;
        $expectedValidateResults = [
            new ValidateResult(false, '[1]', 'Invalid value type. Values in array expected string type.'),
            new ValidateResult(false, '[4]', 'Invalid value type. Values in array expected string type.'),
        ];

        $callableIsString = function ($value, $result) {
            // @var array $value
            // @var Selen\Schema\Validate\Model\ValidateResult $result
            return \is_string($value) ?
                    $result->setResult(true) :
                    $result->setResult(false)->setMessage('Invalid value type. Values in array expected string type.');
        };

        $define = new ArrayDefine(
            Define::noKey()->value($callableIsString)
        );

        $input = [
            'string0',
            0,
            'string2',
            'string3',
            true,
            'string5',
        ];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * 値のバリデーションテスト（1次元配列）定義は存在するが、定義に対応するinput値が存在しないケース
     */
    public function testPattern102()
    {
        $expectedSuccess         = false;
        $expectedValidateResults = [
            new ValidateResult(false, 'key1', 'key is required.'),
            // new ValidateResult(false, 'key2', 'Invalid value type. Expected string type.'),
        ];

        $callableIsString = function ($value, $result) {
            // @var Selen\Schema\Validate\Model\ValidateResult $result
            return \is_string($value) ?
                    $result->setResult(true) :
                    $result->setResult(false)->setMessage('Invalid value type. Expected string type.');
        };

        $define = new ArrayDefine(
            Define::key('key1', true)->value($callableIsString),
            Define::key('key2', false)->value($callableIsString)
        );

        $input = [
            // 'key2' => 0
        ];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * 値のバリデーションテスト（1次元配列）定義は存在し、定義に対応するinput値が存在するケース
     */
    public function testPattern103()
    {
        $expectedSuccess         = false;
        $expectedValidateResults = [
            new ValidateResult(false, 'key2', 'Invalid value type. Expected string type.'),
        ];

        $callableIsString = function ($value, $result) {
            // @var Selen\Schema\Validate\Model\ValidateResult $result
            return \is_string($value) ?
                    $result->setResult(true) :
                    $result->setResult(false)->setMessage('Invalid value type. Expected string type.');
        };

        $define = new ArrayDefine(
            Define::key('key1', true)->value($callableIsString),
            Define::key('key2', false)->value($callableIsString)
        );

        $input = [
            'key1' => 'string',
            'key2' => 0,
        ];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * 値のバリデーションテスト（1次元配列）interfaceを使用した値バリデーション実装
     */
    public function testPattern104()
    {
        $expectedSuccess         = false;
        $expectedValidateResults = [
            new ValidateResult(false, 'key2', 'Invalid value type. Expected string type.'),
        ];

        $validateResultStub1 = new ValidateResult(true, 'key1');
        $validateResultStub2 = new ValidateResult(false, 'key2', 'Invalid value type. Expected string type.');

        $valueValidateStub1 = $this->createStub(ValueValidateInterface::class);
        $valueValidateStub1->method('execute')->willReturn($validateResultStub1);

        $valueValidateStub2 = $this->createStub(ValueValidateInterface::class);
        $valueValidateStub2->method('execute')->willReturn($validateResultStub2);

        $define = new ArrayDefine(
            Define::key('key1', true)->value($valueValidateStub1),
            Define::key('key2', false)->value($valueValidateStub2)
        );

        $input = [
            'key1' => 'string',
            'key2' => 0,
        ];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * 値のバリデーションテスト（配列要素のバリデーションパターン1）
     */
    public function testPattern105()
    {
        /**
         * NOTE: 配列要素内の値バリデーション定義方法は2通りあります
         *       1. 配列を受け取れるバリデーションクラス or callable処理を実装する
         *       2. noKeyを定義し、noKeyのバリデーション定義にリテラル値を受け取れるバリデーションクラス or callableを実装する
         *          違いはバリデーション位置の詳細度が変わるだけ。（1より2のほうが詳細）
         */
        $expectedSuccess         = false;
        $expectedValidateResults = [
            // バリデーション定義方法2の結果
            new ValidateResult(false, 'key2.[1]', 'Invalid type. Expected type string.'),
        ];

        $define = new ArrayDefine(
            Define::key('key2', true)->arrayDefine(
                /**
                 * NOTE: noKeyを指定した場合、バリデーションメソッド（execute,callableの第一引数）に渡される値は
                 *       配列要素の値。配列まるごと渡されるわけではないので注意。
                 */
                Define::noKey()->value(new Type('string'))
            )
        );

        $input = [
            'key2' => [
                'value1',
                0,
                'value3',
            ],
        ];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * 値のバリデーションテスト（複数のバリデーション指定）
     */
    public function testPattern106()
    {
        $expectedSuccess         = true;
        $expectedValidateResults = [
        ];

        $callableStringPattern = function ($value, $result) {
            /** @var \Selen\Schema\Validate\Model\ValidateResult $result */
            return \preg_match('/[\d]{3}-[\d]{4}/', $value) ?
                    $result->setResult(true) :
                    $result->setResult(false)->setMessage("Invalid value format. Expected pattern '/[\\d]{3}-[\\d]{4}/'.");
        };

        $define = new ArrayDefine(
            Define::key('key2', true)->arrayDefine(
                Define::noKey()->value(new Type('string'), $callableStringPattern)
            )
        );

        $input = [
            'key2' => [
                '000-0000',
                '000-0001',
                '000-0002',
            ],
        ];

        $validator = Validator::new();
        $result    = $validator->arrayDefine($define)->execute($input);
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
