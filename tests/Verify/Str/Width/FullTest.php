<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str\Width\Test;

use PHPUnit\Framework\TestCase;
use Selen\Verify\Str\Width\Full;

/**
 * @coversDefaultClass \Selen\Verify\Str\Width\Full
 *
 * @group Selen/Verify/Str
 * @group Selen/Verify/Str/Width
 * @group Selen/Verify/Str/Width/Full
 *
 * @see \Selen\Verify\Str\Width\Full
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Verify/Str/Width/Full
 *
 * @internal
 */
class FullTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Full::class, Full::set(''));
    }

    public function dataProviderExist()
    {
        return [
            // 全角1字
            'pattern001' => ['expected' => true, 'input' => 'あ'],
            'pattern002' => ['expected' => true, 'input' => 'ａ'],
            'pattern003' => ['expected' => true, 'input' => 'Ａ'],
            'pattern004' => ['expected' => true, 'input' => '１'],
            // 半角1字
            'pattern005' => ['expected' => false, 'input' => 'a'],
            'pattern006' => ['expected' => false, 'input' => 'A'],
            'pattern007' => ['expected' => false, 'input' => '1'],
            // 全角2字以上
            'pattern008' => ['expected' => true, 'input' => 'あい'],
            'pattern009' => ['expected' => true, 'input' => 'ａｉ'],
            'pattern010' => ['expected' => true, 'input' => 'ＡＩ'],
            'pattern011' => ['expected' => true, 'input' => '１２'],
            // 半角2字以上
            'pattern012' => ['expected' => false, 'input' => 'ab'],
            'pattern013' => ['expected' => false, 'input' => 'AB'],
            'pattern014' => ['expected' => false, 'input' => '12'],
            // 全角半角混同
            'pattern015' => ['expected' => true, 'input' => 'あa'],
            'pattern016' => ['expected' => true, 'input' => 'ａa'],
            'pattern017' => ['expected' => true, 'input' => 'Ａa'],
            'pattern018' => ['expected' => true, 'input' => '１a'],

            'pattern019' => ['expected' => true, 'input' => 'あA'],
            'pattern020' => ['expected' => true, 'input' => 'ａA'],
            'pattern021' => ['expected' => true, 'input' => 'ＡA'],
            'pattern022' => ['expected' => true, 'input' => '１A'],

            'pattern023' => ['expected' => true, 'input' => 'あ1'],
            'pattern024' => ['expected' => true, 'input' => 'ａ1'],
            'pattern025' => ['expected' => true, 'input' => 'Ａ1'],
            'pattern026' => ['expected' => true, 'input' => '１1'],

            // 例外パターン
            'pattern027' => ['expected' => false, 'input' => ''],
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
        $this->assertSame($expected, (Full::set($input))->exist());
    }

    public function dataProviderNotExist()
    {
        return [
            // 全角1字
            'pattern001' => ['expected' => false, 'input' => 'あ'],
            'pattern002' => ['expected' => false, 'input' => 'ａ'],
            'pattern003' => ['expected' => false, 'input' => 'Ａ'],
            'pattern004' => ['expected' => false, 'input' => '１'],
            // 半角1字
            'pattern005' => ['expected' => true, 'input' => 'a'],
            'pattern006' => ['expected' => true, 'input' => 'A'],
            'pattern007' => ['expected' => true, 'input' => '1'],
            // 全角2字以上
            'pattern008' => ['expected' => false, 'input' => 'あい'],
            'pattern009' => ['expected' => false, 'input' => 'ａｉ'],
            'pattern010' => ['expected' => false, 'input' => 'ＡＩ'],
            'pattern011' => ['expected' => false, 'input' => '１２'],
            // 半角2字以上
            'pattern012' => ['expected' => true, 'input' => 'ab'],
            'pattern013' => ['expected' => true, 'input' => 'AB'],
            'pattern014' => ['expected' => true, 'input' => '12'],
            // 全角半角混同
            'pattern015' => ['expected' => false, 'input' => 'あa'],
            'pattern016' => ['expected' => false, 'input' => 'ａa'],
            'pattern017' => ['expected' => false, 'input' => 'Ａa'],
            'pattern018' => ['expected' => false, 'input' => '１a'],

            'pattern019' => ['expected' => false, 'input' => 'あA'],
            'pattern020' => ['expected' => false, 'input' => 'ａA'],
            'pattern021' => ['expected' => false, 'input' => 'ＡA'],
            'pattern022' => ['expected' => false, 'input' => '１A'],

            'pattern023' => ['expected' => false, 'input' => 'あ1'],
            'pattern024' => ['expected' => false, 'input' => 'ａ1'],
            'pattern025' => ['expected' => false, 'input' => 'Ａ1'],
            'pattern026' => ['expected' => false, 'input' => '１1'],

            // 例外パターン
            'pattern027' => ['expected' => false, 'input' => ''],
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
        $this->assertSame($expected, (Full::set($input))->notExist());
    }

    public function dataProviderOnly()
    {
        return [
            // 全角1字
            'pattern001' => ['expected' => true, 'input' => 'あ'],
            'pattern002' => ['expected' => true, 'input' => 'ａ'],
            'pattern003' => ['expected' => true, 'input' => 'Ａ'],
            'pattern004' => ['expected' => true, 'input' => '１'],
            // 半角1字
            'pattern005' => ['expected' => false, 'input' => 'a'],
            'pattern006' => ['expected' => false, 'input' => 'A'],
            'pattern007' => ['expected' => false, 'input' => '1'],
            // 全角2字以上
            'pattern008' => ['expected' => true, 'input' => 'あい'],
            'pattern009' => ['expected' => true, 'input' => 'ａｉ'],
            'pattern010' => ['expected' => true, 'input' => 'ＡＩ'],
            'pattern011' => ['expected' => true, 'input' => '１２'],
            // 半角2字以上
            'pattern012' => ['expected' => false, 'input' => 'ab'],
            'pattern013' => ['expected' => false, 'input' => 'AB'],
            'pattern014' => ['expected' => false, 'input' => '12'],
            // 全角半角混同
            'pattern015' => ['expected' => false, 'input' => 'あa'],
            'pattern016' => ['expected' => false, 'input' => 'ａa'],
            'pattern017' => ['expected' => false, 'input' => 'Ａa'],
            'pattern018' => ['expected' => false, 'input' => '１a'],

            'pattern019' => ['expected' => false, 'input' => 'あA'],
            'pattern020' => ['expected' => false, 'input' => 'ａA'],
            'pattern021' => ['expected' => false, 'input' => 'ＡA'],
            'pattern022' => ['expected' => false, 'input' => '１A'],

            'pattern023' => ['expected' => false, 'input' => 'あ1'],
            'pattern024' => ['expected' => false, 'input' => 'ａ1'],
            'pattern025' => ['expected' => false, 'input' => 'Ａ1'],
            'pattern026' => ['expected' => false, 'input' => '１1'],

            // 例外パターン
            'pattern027' => ['expected' => false, 'input' => ''],
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
        $this->assertSame($expected, (Full::set($input))->only());
    }

    public function dataProviderNotOnly()
    {
        return [
            // 全角1字
            'pattern001' => ['expected' => false, 'input' => 'あ'],
            'pattern002' => ['expected' => false, 'input' => 'ａ'],
            'pattern003' => ['expected' => false, 'input' => 'Ａ'],
            'pattern004' => ['expected' => false, 'input' => '１'],
            // 半角1字
            'pattern005' => ['expected' => true, 'input' => 'a'],
            'pattern006' => ['expected' => true, 'input' => 'A'],
            'pattern007' => ['expected' => true, 'input' => '1'],
            // 全角2字以上
            'pattern008' => ['expected' => false, 'input' => 'あい'],
            'pattern009' => ['expected' => false, 'input' => 'ａｉ'],
            'pattern010' => ['expected' => false, 'input' => 'ＡＩ'],
            'pattern011' => ['expected' => false, 'input' => '１２'],
            // 半角2字以上
            'pattern012' => ['expected' => true, 'input' => 'ab'],
            'pattern013' => ['expected' => true, 'input' => 'AB'],
            'pattern014' => ['expected' => true, 'input' => '12'],
            // 全角半角混同
            'pattern015' => ['expected' => true, 'input' => 'あa'],
            'pattern016' => ['expected' => true, 'input' => 'ａa'],
            'pattern017' => ['expected' => true, 'input' => 'Ａa'],
            'pattern018' => ['expected' => true, 'input' => '１a'],

            'pattern019' => ['expected' => true, 'input' => 'あA'],
            'pattern020' => ['expected' => true, 'input' => 'ａA'],
            'pattern021' => ['expected' => true, 'input' => 'ＡA'],
            'pattern022' => ['expected' => true, 'input' => '１A'],

            'pattern023' => ['expected' => true, 'input' => 'あ1'],
            'pattern024' => ['expected' => true, 'input' => 'ａ1'],
            'pattern025' => ['expected' => true, 'input' => 'Ａ1'],
            'pattern026' => ['expected' => true, 'input' => '１1'],

            // 例外パターン
            'pattern027' => ['expected' => false, 'input' => ''],
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
        $this->assertSame($expected, (Full::set($input))->notOnly());
    }
}
