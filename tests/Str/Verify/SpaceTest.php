<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Str\Verify;

use PHPUnit\Framework\TestCase;
use Selen\Str\Verify\Space;

/**
 * @coversDefaultClass \Selen\Str\Verify\Space
 *
 * @see Space
 *
 * @internal
 */
class SpaceTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Space::class, Space::set(''));
    }

    public function dataProviderExist()
    {
        return [
            'pattern001' => ['expected' => false, 'input' => ''],
            'pattern002' => ['expected' => false, 'input' => 'a'],
            'pattern003' => ['expected' => false, 'input' => '\r'],
            'pattern004' => ['expected' => true,  'input' => "\r"],
            'pattern005' => ['expected' => false, 'input' => '\n'],
            'pattern006' => ['expected' => true,  'input' => "\n"],
            'pattern007' => ['expected' => false, 'input' => '\t'],
            'pattern008' => ['expected' => true,  'input' => "\t"],

            // 全角1字
            'pattern009' => ['expected' => true,  'input' => '　'],
            'pattern010' => ['expected' => true,  'input' => 'あ　'],
            'pattern011' => ['expected' => true,  'input' => '　あ'],
            'pattern012' => ['expected' => true,  'input' => 'あ　い'],
            // 半角1字
            'pattern013' => ['expected' => true,  'input' => ' '],
            'pattern014' => ['expected' => true,  'input' => 'a '],
            'pattern015' => ['expected' => true,  'input' => ' a'],
            'pattern016' => ['expected' => true,  'input' => 'a a'],
            // 全角2字以上
            'pattern017' => ['expected' => true,  'input' => '　　'],
            'pattern018' => ['expected' => true,  'input' => 'あ　　'],
            'pattern019' => ['expected' => true,  'input' => '　　あ'],
            'pattern020' => ['expected' => true,  'input' => 'あ　　い'],
            // 半角2字以上
            'pattern021' => ['expected' => true,  'input' => '  '],
            'pattern022' => ['expected' => true,  'input' => 'a  '],
            'pattern023' => ['expected' => true,  'input' => '  a'],
            'pattern024' => ['expected' => true,  'input' => 'a  a'],
            // 全角半角混同
            'pattern025' => ['expected' => true,  'input' => ' 　'],
        ];
    }

    /**
     * @dataProvider dataProviderExist
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testExist($expected, $input)
    {
        $this->assertSame($expected, (Space::set($input))->exist());
    }

    public function dataProviderNotExist()
    {
        return [
            'pattern001' => ['expected' => true,  'input' => ''],
            'pattern002' => ['expected' => true,  'input' => 'a'],
            'pattern003' => ['expected' => true,  'input' => '\r'],
            'pattern004' => ['expected' => false, 'input' => "\r"],
            'pattern005' => ['expected' => true,  'input' => '\n'],
            'pattern006' => ['expected' => false, 'input' => "\n"],
            'pattern007' => ['expected' => true,  'input' => '\t'],
            'pattern008' => ['expected' => false, 'input' => "\t"],

            // 全角1字
            'pattern009' => ['expected' => false,  'input' => '　'],
            'pattern010' => ['expected' => false,  'input' => 'あ　'],
            'pattern011' => ['expected' => false,  'input' => '　あ'],
            'pattern012' => ['expected' => false,  'input' => 'あ　い'],
            // 半角1字
            'pattern013' => ['expected' => false,  'input' => ' '],
            'pattern014' => ['expected' => false,  'input' => 'a '],
            'pattern015' => ['expected' => false,  'input' => ' a'],
            'pattern016' => ['expected' => false,  'input' => 'a a'],
            // 全角2字以上
            'pattern017' => ['expected' => false,  'input' => '　　'],
            'pattern018' => ['expected' => false,  'input' => 'あ　　'],
            'pattern019' => ['expected' => false,  'input' => '　　あ'],
            'pattern020' => ['expected' => false,  'input' => 'あ　　い'],
            // 半角2字以上
            'pattern021' => ['expected' => false,  'input' => '  '],
            'pattern022' => ['expected' => false,  'input' => 'a  '],
            'pattern023' => ['expected' => false,  'input' => '  a'],
            'pattern024' => ['expected' => false,  'input' => 'a  a'],
            // 全角半角混同
            'pattern025' => ['expected' => false,  'input' => ' 　'],
        ];
    }

    /**
     * @dataProvider dataProviderNotExist
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testNotExist($expected, $input)
    {
        $this->assertSame($expected, (Space::set($input))->notExist());
    }

    public function dataProviderOnly()
    {
        return [
            'pattern001' => ['expected' => false, 'input' => ''],
            'pattern002' => ['expected' => false, 'input' => 'a'],
            'pattern003' => ['expected' => false, 'input' => '\r'],
            'pattern004' => ['expected' => true,  'input' => "\r"],
            'pattern005' => ['expected' => false, 'input' => '\n'],
            'pattern006' => ['expected' => true,  'input' => "\n"],
            'pattern007' => ['expected' => false, 'input' => '\t'],
            'pattern008' => ['expected' => true,  'input' => "\t"],

            // 全角1字
            'pattern009' => ['expected' => true,  'input' => '　'],
            'pattern010' => ['expected' => false, 'input' => 'あ　'],
            'pattern011' => ['expected' => false, 'input' => '　あ'],
            'pattern012' => ['expected' => false, 'input' => 'あ　い'],
            // 半角1字
            'pattern013' => ['expected' => true,  'input' => ' '],
            'pattern014' => ['expected' => false, 'input' => 'a '],
            'pattern015' => ['expected' => false, 'input' => ' a'],
            'pattern016' => ['expected' => false, 'input' => 'a a'],
            // 全角2字以上
            'pattern017' => ['expected' => true,  'input' => '　　'],
            'pattern018' => ['expected' => false, 'input' => 'あ　　'],
            'pattern019' => ['expected' => false, 'input' => '　　あ'],
            'pattern020' => ['expected' => false, 'input' => 'あ　　い'],
            // 半角2字以上
            'pattern021' => ['expected' => true,  'input' => '  '],
            'pattern022' => ['expected' => false, 'input' => 'a  '],
            'pattern023' => ['expected' => false, 'input' => '  a'],
            'pattern024' => ['expected' => false, 'input' => 'a  a'],
            // 全角半角混同
            'pattern025' => ['expected' => true,  'input' => ' 　'],
        ];
    }

    /**
     * @dataProvider dataProviderOnly
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testOnly($expected, $input)
    {
        $this->assertSame($expected, (Space::set($input))->only());
    }

    public function dataProviderNotOnly()
    {
        return [
            'pattern001' => ['expected' => true,  'input' => ''],
            'pattern002' => ['expected' => true,  'input' => 'a'],
            'pattern003' => ['expected' => true,  'input' => '\r'],
            'pattern004' => ['expected' => false, 'input' => "\r"],
            'pattern005' => ['expected' => true,  'input' => '\n'],
            'pattern006' => ['expected' => false, 'input' => "\n"],
            'pattern007' => ['expected' => true,  'input' => '\t'],
            'pattern008' => ['expected' => false, 'input' => "\t"],

            // 全角1字
            'pattern009' => ['expected' => false, 'input' => '　'],
            'pattern010' => ['expected' => true,  'input' => 'あ　'],
            'pattern011' => ['expected' => true,  'input' => '　あ'],
            'pattern012' => ['expected' => true,  'input' => 'あ　い'],
            // 半角1字
            'pattern013' => ['expected' => false, 'input' => ' '],
            'pattern014' => ['expected' => true,  'input' => 'a '],
            'pattern015' => ['expected' => true,  'input' => ' a'],
            'pattern016' => ['expected' => true,  'input' => 'a a'],
            // 全角2字以上
            'pattern017' => ['expected' => false, 'input' => '　　'],
            'pattern018' => ['expected' => true,  'input' => 'あ　　'],
            'pattern019' => ['expected' => true,  'input' => '　　あ'],
            'pattern020' => ['expected' => true,  'input' => 'あ　　い'],
            // 半角2字以上
            'pattern021' => ['expected' => false, 'input' => '  '],
            'pattern022' => ['expected' => true,  'input' => 'a  '],
            'pattern023' => ['expected' => true,  'input' => '  a'],
            'pattern024' => ['expected' => true,  'input' => 'a  a'],
            // 全角半角混同
            'pattern025' => ['expected' => false, 'input' => ' 　'],
        ];
    }

    /**
     * @dataProvider dataProviderNotOnly
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testNotOnly($expected, $input)
    {
        $this->assertSame($expected, (Space::set($input))->notOnly());
    }
}
