<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Define;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Define;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Define
 *
 * @see \Selen\Schema\Validate\Define
 *
 * @internal
 */
class DefineTest extends TestCase
{
    public function dataProviderKeyAndNoKeyCall()
    {
        $validateResultStub = $this->createStub(ValidateResult::class);
        $valueValidateStub  = $this->createStub(ValueValidateInterface::class);
        $valueValidateStub->method('execute')->willReturn($validateResultStub);

        $key = Define::noKey();
        $this->assertInstanceOf(Define::class, $key->value(
            $valueValidateStub
        ));

        return [
            'callKeyAndIndexTypeString' => [
                'expected' => Define::class,
                'input'    => Define::key('keyName', true),
            ],
            'callKeyAndIndexTypeInteger' => [
                'expected' => Define::class,
                'input'    => Define::key(0, true),
            ],
            'callNoKey' => [
                'expected' => Define::class,
                'input'    => Define::noKey(),
            ],
            'callKeyAfterValue' => [
                'expected' => Define::class,
                'input'    => Define::key('keyName', true)->value(),
            ],
            'callNoKeyAfterValue' => [
                'expected' => Define::class,
                'input'    => Define::noKey()->value(),
            ],
            'callKeyAndAfterValueArgCallableType' => [
                'expected' => Define::class,
                'input'    => Define::key('keyName', true)->value(function () {}),
            ],
            'callNoKeyAndAfterValueArgCallableType' => [
                'expected' => Define::class,
                'input'    => Define::noKey()->value(function () {}),
            ],
            'callKeyAndAfterValueArgInstanceType' => [
                'expected' => Define::class,
                'input'    => Define::key('keyName', true)->value($valueValidateStub),
            ],
            'callNoKeyAndAfterValueArgInstanceType' => [
                'expected' => Define::class,
                'input'    => Define::noKey()->value($valueValidateStub),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderKeyAndNoKeyCall
     *
     * テスト内容:
     *  - メソッドの呼び出し方
     *  - value()メソッドの引数が許容する値の型をチェック
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testKeyAndNoKeyCall($expected, $input)
    {
        $this->assertInstanceOf($expected, $input);
    }

    public function dataProviderKeyAndNoKeyCallException()
    {
        return [
            'callKeyAndIndexTypeNull' => [
                'expected' => \InvalidArgumentException::class,
                'input'    => [
                    'keyArgs' => [null, true],
                ],
            ],
        ];
    }
    /**
     * @dataProvider dataProviderKeyAndNoKeyCallException
     *
     * テスト内容:
     *  - value()メソッドの引数が許容できない値をチェック
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testKeyAndNoKeyCallException($expected, $input)
    {
        [
            'keyArgs' => $keyArgs
        ] = $input;

        $this->expectException($expected);
        Define::key(...$keyArgs);
    }

    public function dataProviderCallPatternSuccess()
    {
        return [
            'callPattern: Define::key()->value()' => [
                'expected' => Define::class,
                'callback' => function () {
                    return Define::key('keyName', true)->value();
                },
            ],
            'callPattern: Define::key()->arrayDefine()' => [
                'expected' => Define::class,
                'callback' => function () {
                    return Define::key('keyName', true)->arrayDefine();
                },
            ],
            'callPattern: Define::key()->value()->arrayDefine()' => [
                'expected' => Define::class,
                'callback' => function () {
                    return Define::key('keyName', true)->value()->arrayDefine();
                },
            ],
            'callPattern: Define::noKey()->value()' => [
                'expected' => Define::class,
                'callback' => function () {
                    return Define::noKey()->value();
                },
            ],
            'callPattern: Define::noKey()->arrayDefine()' => [
                'expected' => Define::class,
                'callback' => function () {
                    return Define::noKey()->arrayDefine();
                },
            ],
            'callPattern: Define::noKey()->value()->arrayDefine()' => [
                'expected' => Define::class,
                'callback' => function () {
                    return Define::noKey()->value()->arrayDefine();
                },
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCallPatternSuccess
     *
     * テスト内容
     * - 許容されるメソッドチェーンのパターンをテスト
     *
     * @param mixed $expected
     * @param mixed $callback
     */
    public function testCallPatternSuccess($expected, $callback)
    {
        $this->assertInstanceOf($expected, ($callback)());
    }

    public function dataProviderCallPatternFailure()
    {
        return [
            'callPattern: Define::key()->value()->value()' => [
                'expected' => \LogicException::class,
                'callback' => function () {
                    return Define::key('keyName', true)->value()->value();
                },
            ],
            'callPattern: Define::key()->arrayDefine()->arrayDefine()' => [
                'expected' => \LogicException::class,
                'callback' => function () {
                    return Define::key('keyName', true)->arrayDefine()->arrayDefine();
                },
            ],
            'callPattern: Define::key()->arrayDefine()->value()' => [
                'expected' => \LogicException::class,
                'callback' => function () {
                    return Define::key('keyName', true)->arrayDefine()->value();
                },
            ],
            'callPattern: Define::noKey()->value()->value()' => [
                'expected' => \LogicException::class,
                'callback' => function () {
                    return Define::noKey()->value()->value();
                },
            ],
            'callPattern: Define::noKey()->arrayDefine()->arrayDefine()' => [
                'expected' => \LogicException::class,
                'callback' => function () {
                    return Define::noKey()->arrayDefine()->arrayDefine();
                },
            ],
            'callPattern: Define::noKey()->arrayDefine()->value()' => [
                'expected' => \LogicException::class,
                'callback' => function () {
                    return Define::noKey()->arrayDefine()->value();
                },
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCallPatternFailure
     *
     * テスト内容
     * - 許容されないメソッドチェーンのパターンをテスト
     *
     * @param mixed $expected
     * @param mixed $callback
     */
    public function testCallPatternFailure($expected, $callback)
    {
        $this->expectException($expected);
        ($callback)();
    }

    public function testArrayDefineException3()
    {
        // NOTE: 変換処理の引数のcallableまたはValueValidateInterface以外のものを指定
        $this->expectException(\InvalidArgumentException::class);
        $key = Define::noKey()->value('string');
    }

    public function dataProviderIsIndexArrayDefine()
    {
        return [
            'pattern001' => ['expected' => false, 'input' => Define::key('str', true)],
            'pattern002' => ['expected' => false, 'input' => Define::key('0', true)],
            'pattern003' => ['expected' => false, 'input' => Define::key(0, true)],
            'pattern004' => ['expected' => true,  'input' => Define::noKey()],
        ];
    }

    /**
     * @dataProvider dataProviderIsIndexArrayDefine
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testIsIndexArrayDefine($expected, $input)
    {
        // @var \Selen\Schema\Validate\Define $input
        $this->assertSame($expected, $input->isIndexArrayDefine());
    }

    public function dataProviderIsAssocArrayDefine()
    {
        return [
            'pattern001' => ['expected' => true,  'input' => Define::key('str', true)],
            'pattern002' => ['expected' => true,  'input' => Define::key('0', true)],
            'pattern003' => ['expected' => true,  'input' => Define::key(0, true)],
            'pattern004' => ['expected' => false, 'input' => Define::noKey()],
        ];
    }

    /**
     * @dataProvider dataProviderIsAssocArrayDefine
     *
     * @param mixed $expected
     * @param \Selen\Schema\Validate\Define $input
     */
    public function testIsAssocArrayDefine($expected, $input)
    {
        $this->assertSame($expected, $input->isAssocArrayDefine());
    }

    public function dataProviderIsKeyValidate()
    {
        return [
            'pattern001' => ['expected' => true, 'input' => Define::key('keyName', true)],
            'pattern002' => ['expected' => false, 'input' => Define::key('keyName', false)],
            'pattern003' => ['expected' => false, 'input' => Define::noKey()],
        ];
    }

    /**
     * @dataProvider dataProviderIsKeyValidate
     *
     * @param mixed $expected
     * @param \Selen\Schema\Validate\Define $input
     */
    public function testIsKeyValidate($expected, $input)
    {
        $this->assertSame($expected, $input->isKeyValidate());
    }

    public function dataProviderIsValueValidate()
    {
        return [
            'pattern001' => ['expected' => false, 'input' => Define::key('keyName', true)],
            'pattern002' => ['expected' => false, 'input' => Define::key('keyName', false)],
            'pattern004' => ['expected' => false, 'input' => Define::noKey()],

            'pattern005' => ['expected' => true, 'input' => (Define::key('keyName', true))->value()],
            'pattern006' => ['expected' => true, 'input' => (Define::key('keyName', false))->value()],
            'pattern008' => ['expected' => true, 'input' => (Define::noKey())->value()],

            'pattern009' => ['expected' => false, 'input' => (Define::key('keyName', true))->arrayDefine()],
            'pattern010' => ['expected' => false, 'input' => (Define::key('keyName', false))->arrayDefine()],
            'pattern012' => ['expected' => false, 'input' => (Define::noKey())->arrayDefine()],
        ];
    }

    /**
     * @dataProvider dataProviderIsValueValidate
     *
     * @param mixed $expected
     * @param \Selen\Schema\Validate\Define $input
     */
    public function testIsValueValidate($expected, $input)
    {
        $this->assertSame($expected, $input->isValueValidate());
    }

    public function dataProviderNestedTypeDefineExists()
    {
        return [
            'pattern001' => ['expected' => false, 'input' => Define::key('str', true)],
            'pattern002' => ['expected' => false, 'input' => Define::key('0', true)],
            'pattern003' => ['expected' => false, 'input' => Define::key(0, true)],
            'pattern004' => ['expected' => false, 'input' => Define::noKey()],

            'pattern005' => ['expected' => false, 'input' => (Define::key('str', true))->value()],
            'pattern006' => ['expected' => false, 'input' => (Define::key('0', true))->value()],
            'pattern007' => ['expected' => false, 'input' => (Define::key(0, true))->value()],
            'pattern008' => ['expected' => false, 'input' => (Define::noKey())->value()],

            'pattern009' => ['expected' => true, 'input' => (Define::key('str', true))->arrayDefine()],
            'pattern010' => ['expected' => true, 'input' => (Define::key('0', true))->arrayDefine()],
            'pattern011' => ['expected' => true, 'input' => (Define::key(0, true))->arrayDefine()],
            'pattern012' => ['expected' => true, 'input' => (Define::noKey())->arrayDefine()],
        ];
    }

    /**
     * @dataProvider dataProviderNestedTypeDefineExists
     *
     * @param mixed $expected
     * @param \Selen\Schema\Validate\Define $input
     */
    public function testNestedTypeDefineExists($expected, $input)
    {
        $this->assertSame($expected, $input->nestedTypeDefineExists());
    }
}
