<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Exchange\Define\Test;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Exchange\Define;
use Selen\Schema\Exchange\ValueExchangeInterface;

/**
 * @coversDefaultClass \Selen\Schema\Exchange\Define
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Exchange
 * @group Selen/Schema/Exchange/Define
 *
 * @see \Selen\Schema\Exchange\Define
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Exchange/Define
 *
 * @internal
 */
class DefineTest extends TestCase
{
    public function testKey()
    {
        $this->assertInstanceOf(Define::class, Define::key('keyName'));
        $this->assertInstanceOf(Define::class, Define::key(0));
    }

    public function testKeyException()
    {
        $this->expectException(\InvalidArgumentException::class);
        Define::key(null);
    }

    public function testNoKey()
    {
        $this->assertInstanceOf(Define::class, Define::noKey());
    }

    public function testValue1()
    {
        $key = Define::key('keyName');
        $this->assertInstanceOf(Define::class, $key->value());
    }

    public function testValueException1()
    {
        // NOTE: 配列形式の定義と変換の定義は同時に呼び出すことはできない
        $key = Define::key('keyName')->arrayDefine();

        $this->expectException(\LogicException::class);
        $key->value();
    }

    public function testValue2()
    {
        $key = Define::noKey();
        $this->assertInstanceOf(Define::class, $key->value());
    }

    public function testValueException2()
    {
        // NOTE: 配列形式の定義と変換の定義は同時に呼び出すことはできない
        $key = Define::noKey()->arrayDefine();

        $this->expectException(\LogicException::class);
        $key->value();
    }

    public function testValue3()
    {
        $key = Define::noKey();
        $this->assertInstanceOf(Define::class, $key->value(
            function () {}
        ));
    }

    public function testValueException3()
    {
        // NOTE: 配列形式の定義と変換の定義は同時に呼び出すことはできない
        $key = Define::noKey()->arrayDefine();

        $this->expectException(\LogicException::class);
        $key->value(
            true
        );
    }

    public function testValue4()
    {
        $stub1 = $this->createStub(ValueExchangeInterface::class);
        $stub1->method('execute')->willReturn('replace string 2');

        $key = Define::noKey();
        $this->assertInstanceOf(Define::class, $key->value(
            $stub1
        ));
    }

    public function testArrayDefine1()
    {
        $key = Define::key('keyName');
        $this->assertInstanceOf(Define::class, $key->arrayDefine());
    }

    public function testArrayDefineException1()
    {
        // NOTE: 配列形式の定義と変換の定義は同時に呼び出すことはできない
        $key = Define::key('keyName')->value();

        $this->expectException(\LogicException::class);
        $key->arrayDefine();
    }

    public function testArrayDefine2()
    {
        $key = Define::noKey();
        $this->assertInstanceOf(Define::class, $key->arrayDefine());
    }

    public function testArrayDefineException2()
    {
        // NOTE: 配列形式の定義と変換の定義は同時に呼び出すことはできない
        $key = Define::noKey()->value();

        $this->expectException(\LogicException::class);
        $key->arrayDefine();
    }

    public function testArrayDefine3()
    {
        $key = Define::noKey();
        $this->assertInstanceOf(Define::class, $key->arrayDefine());
    }

    public function testArrayDefineException3()
    {
        // NOTE: 変換処理の引数のcallableまたはValueExchangeInterface以外のものを指定
        $this->expectException(\InvalidArgumentException::class);
        $key = Define::noKey()->value('string');
    }

    public function dataProviderIsIndexArrayDefine()
    {
        return [
            'pattern001' => ['expected' => false, 'input' => Define::key('str')],
            'pattern002' => ['expected' => false, 'input' => Define::key('0')],
            'pattern003' => ['expected' => false, 'input' => Define::key(0)],
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
        // @var \Selen\Schema\Exchange\Define $input
        $this->assertSame($expected, $input->isIndexArrayDefine());
    }

    public function dataProviderIsAssocArrayDefine()
    {
        return [
            'pattern001' => ['expected' => true,  'input' => Define::key('str')],
            'pattern002' => ['expected' => true,  'input' => Define::key('0')],
            'pattern003' => ['expected' => true,  'input' => Define::key(0)],
            'pattern004' => ['expected' => false, 'input' => Define::noKey()],
        ];
    }

    /**
     * @dataProvider dataProviderIsAssocArrayDefine
     *
     * @param mixed $expected
     * @param \Selen\Schema\Exchange\Define $input
     */
    public function testIsAssocArrayDefine($expected, $input)
    {
        $this->assertSame($expected, $input->isAssocArrayDefine());
    }

    public function dataProviderNestedTypeDefineExists()
    {
        return [
            'pattern001' => ['expected' => false, 'input' => Define::key('str')],
            'pattern002' => ['expected' => false, 'input' => Define::key('0')],
            'pattern003' => ['expected' => false, 'input' => Define::key(0)],
            'pattern004' => ['expected' => false, 'input' => Define::noKey()],

            'pattern005' => ['expected' => false, 'input' => (Define::key('str'))->value()],
            'pattern006' => ['expected' => false, 'input' => (Define::key('0'))->value()],
            'pattern007' => ['expected' => false, 'input' => (Define::key(0))->value()],
            'pattern008' => ['expected' => false, 'input' => (Define::noKey())->value()],

            'pattern009' => ['expected' => true, 'input' => (Define::key('str'))->arrayDefine()],
            'pattern010' => ['expected' => true, 'input' => (Define::key('0'))->arrayDefine()],
            'pattern011' => ['expected' => true, 'input' => (Define::key(0))->arrayDefine()],
            'pattern012' => ['expected' => true, 'input' => (Define::noKey())->arrayDefine()],
        ];
    }

    /**
     * @dataProvider dataProviderNestedTypeDefineExists
     *
     * @param mixed $expected
     * @param \Selen\Schema\Exchange\Define $input
     */
    public function testNestedTypeDefineExists($expected, $input)
    {
        $this->assertSame($expected, $input->nestedTypeDefineExists());
    }
}
