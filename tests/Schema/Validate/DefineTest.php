<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Define;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Define
 *
 * @see Define
 *
 * @internal
 */
class DefineTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderKeyAndNoKeyCall(): array
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
    public function testKeyAndNoKeyCall($expected, $input): void
    {
        $this->assertInstanceOf($expected, $input);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderCallPatternSuccess(): array
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
    public function testCallPatternSuccess($expected, $callback): void
    {
        $this->assertInstanceOf($expected, ($callback)());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderCallPatternFailure(): array
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
    public function testCallPatternFailure($expected, $callback): void
    {
        $this->expectException($expected);
        ($callback)();
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderIsIndexArrayDefine(): array
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
    public function testIsIndexArrayDefine($expected, $input): void
    {
        // @var \Selen\Schema\Validate\Define $input
        $this->assertSame($expected, $input->isIndexArrayDefine());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderIsAssocArrayDefine(): array
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
     * @param mixed  $expected
     * @param Define $input
     */
    public function testIsAssocArrayDefine($expected, $input): void
    {
        $this->assertSame($expected, $input->isAssocArrayDefine());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderIsKeyValidate(): array
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
     * @param mixed  $expected
     * @param Define $input
     */
    public function testIsKeyValidate($expected, $input): void
    {
        $this->assertSame($expected, $input->isKeyValidate());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderIsValueValidate(): array
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
     * @param mixed  $expected
     * @param Define $input
     */
    public function testIsValueValidate($expected, $input): void
    {
        $this->assertSame($expected, $input->isValueValidate());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderNestedTypeDefineExists(): array
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
     * @param mixed  $expected
     * @param Define $input
     */
    public function testNestedTypeDefineExists($expected, $input): void
    {
        $this->assertSame($expected, $input->nestedTypeDefineExists());
    }
}
