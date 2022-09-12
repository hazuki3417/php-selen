<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Define\Test;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Define;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Define
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Define
 *
 * @see \Selen\Schema\Validate\Define
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Define
 *
 * @internal
 */
class DefineTest extends TestCase
{
    public function testKey()
    {
        $this->assertInstanceOf(Define::class, Define::key('keyName', true));
        $this->assertInstanceOf(Define::class, Define::key(0, true));
    }

    public function testKeyException()
    {
        $this->expectException(\InvalidArgumentException::class);
        Define::key(null, true);
    }

    public function testNoKey()
    {
        $this->assertInstanceOf(Define::class, Define::noKey());
    }

    public function testValue1()
    {
        $key = Define::key('keyName', true);
        $this->assertInstanceOf(Define::class, $key->value());
    }

    public function testValueException1()
    {
        // NOTE: 配列形式の定義と変換の定義は同時に呼び出すことはできない
        $key = Define::key('keyName', true)->arrayDefine();

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
        $validateResultStub = $this->createStub(ValidateResult::class);
        $valueValidateStub  = $this->createStub(ValueValidateInterface::class);
        $valueValidateStub->method('execute')->willReturn($validateResultStub);

        $key = Define::noKey();
        $this->assertInstanceOf(Define::class, $key->value(
            $valueValidateStub
        ));
    }

    public function testArrayDefine1()
    {
        $key = Define::key('keyName', true);
        $this->assertInstanceOf(Define::class, $key->arrayDefine());
    }

    public function testArrayDefineException1()
    {
        // NOTE: 配列形式の定義と変換の定義は同時に呼び出すことはできない
        $key = Define::key('keyName', true)->value();

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
