<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Str\Verify\Width;

use PHPUnit\Framework\TestCase;
use Selen\Str\Verify\Width\Full;

/**
 * @coversDefaultClass \Selen\Str\Verify\Width\Full
 *
 * @see Full
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
            'pattern: 001' => ['expected' => true, 'input' => 'あ'],
            'pattern: 002' => ['expected' => true, 'input' => 'ａ'],
            'pattern: 003' => ['expected' => true, 'input' => 'Ａ'],
            'pattern: 004' => ['expected' => true, 'input' => '１'],
            // 半角1字
            'pattern: 005' => ['expected' => false, 'input' => 'a'],
            'pattern: 006' => ['expected' => false, 'input' => 'A'],
            'pattern: 007' => ['expected' => false, 'input' => '1'],
            // 全角2字以上
            'pattern: 008' => ['expected' => true, 'input' => 'あい'],
            'pattern: 009' => ['expected' => true, 'input' => 'ａｉ'],
            'pattern: 010' => ['expected' => true, 'input' => 'ＡＩ'],
            'pattern: 011' => ['expected' => true, 'input' => '１２'],
            // 半角2字以上
            'pattern: 012' => ['expected' => false, 'input' => 'ab'],
            'pattern: 013' => ['expected' => false, 'input' => 'AB'],
            'pattern: 014' => ['expected' => false, 'input' => '12'],
            // 全角半角混同（英小文字）
            'pattern: 015' => ['expected' => true, 'input' => 'あa'],
            'pattern: 016' => ['expected' => true, 'input' => 'ａa'],
            'pattern: 017' => ['expected' => true, 'input' => 'Ａa'],
            'pattern: 018' => ['expected' => true, 'input' => '１a'],
            // 全角半角混同（英大文字）
            'pattern: 019' => ['expected' => true, 'input' => 'あA'],
            'pattern: 020' => ['expected' => true, 'input' => 'ａA'],
            'pattern: 021' => ['expected' => true, 'input' => 'ＡA'],
            'pattern: 022' => ['expected' => true, 'input' => '１A'],
            // 全角半角混同（英数字）
            'pattern: 023' => ['expected' => true, 'input' => 'あ1'],
            'pattern: 024' => ['expected' => true, 'input' => 'ａ1'],
            'pattern: 025' => ['expected' => true, 'input' => 'Ａ1'],
            'pattern: 026' => ['expected' => true, 'input' => '１1'],
            // 例外パターン
            'pattern: 027' => ['expected' => false, 'input' => ''],
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
            'pattern: 001' => ['expected' => false, 'input' => 'あ'],
            'pattern: 002' => ['expected' => false, 'input' => 'ａ'],
            'pattern: 003' => ['expected' => false, 'input' => 'Ａ'],
            'pattern: 004' => ['expected' => false, 'input' => '１'],
            // 半角1字
            'pattern: 005' => ['expected' => true, 'input' => 'a'],
            'pattern: 006' => ['expected' => true, 'input' => 'A'],
            'pattern: 007' => ['expected' => true, 'input' => '1'],
            // 全角2字以上
            'pattern: 008' => ['expected' => false, 'input' => 'あい'],
            'pattern: 009' => ['expected' => false, 'input' => 'ａｉ'],
            'pattern: 010' => ['expected' => false, 'input' => 'ＡＩ'],
            'pattern: 011' => ['expected' => false, 'input' => '１２'],
            // 半角2字以上
            'pattern: 012' => ['expected' => true, 'input' => 'ab'],
            'pattern: 013' => ['expected' => true, 'input' => 'AB'],
            'pattern: 014' => ['expected' => true, 'input' => '12'],
            // 全角半角混同（英小文字）
            'pattern: 015' => ['expected' => false, 'input' => 'あa'],
            'pattern: 016' => ['expected' => false, 'input' => 'ａa'],
            'pattern: 017' => ['expected' => false, 'input' => 'Ａa'],
            'pattern: 018' => ['expected' => false, 'input' => '１a'],
            // 全角半角混同（英大文字）
            'pattern: 019' => ['expected' => false, 'input' => 'あA'],
            'pattern: 020' => ['expected' => false, 'input' => 'ａA'],
            'pattern: 021' => ['expected' => false, 'input' => 'ＡA'],
            'pattern: 022' => ['expected' => false, 'input' => '１A'],
            // 全角半角混同（英数字）
            'pattern: 023' => ['expected' => false, 'input' => 'あ1'],
            'pattern: 024' => ['expected' => false, 'input' => 'ａ1'],
            'pattern: 025' => ['expected' => false, 'input' => 'Ａ1'],
            'pattern: 026' => ['expected' => false, 'input' => '１1'],
            // 例外パターン
            'pattern: 027' => ['expected' => true, 'input' => ''],
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
            'pattern: 001' => ['expected' => true, 'input' => 'あ'],
            'pattern: 002' => ['expected' => true, 'input' => 'ａ'],
            'pattern: 003' => ['expected' => true, 'input' => 'Ａ'],
            'pattern: 004' => ['expected' => true, 'input' => '１'],
            // 半角1字
            'pattern: 005' => ['expected' => false, 'input' => 'a'],
            'pattern: 006' => ['expected' => false, 'input' => 'A'],
            'pattern: 007' => ['expected' => false, 'input' => '1'],
            // 全角2字以上
            'pattern: 008' => ['expected' => true, 'input' => 'あい'],
            'pattern: 009' => ['expected' => true, 'input' => 'ａｉ'],
            'pattern: 010' => ['expected' => true, 'input' => 'ＡＩ'],
            'pattern: 011' => ['expected' => true, 'input' => '１２'],
            // 半角2字以上
            'pattern: 012' => ['expected' => false, 'input' => 'ab'],
            'pattern: 013' => ['expected' => false, 'input' => 'AB'],
            'pattern: 014' => ['expected' => false, 'input' => '12'],
            // 全角半角混同（英小文字）
            'pattern: 015' => ['expected' => false, 'input' => 'あa'],
            'pattern: 016' => ['expected' => false, 'input' => 'ａa'],
            'pattern: 017' => ['expected' => false, 'input' => 'Ａa'],
            'pattern: 018' => ['expected' => false, 'input' => '１a'],
            // 全角半角混同（英大文字）
            'pattern: 019' => ['expected' => false, 'input' => 'あA'],
            'pattern: 020' => ['expected' => false, 'input' => 'ａA'],
            'pattern: 021' => ['expected' => false, 'input' => 'ＡA'],
            'pattern: 022' => ['expected' => false, 'input' => '１A'],
            // 全角半角混同（英数字）
            'pattern: 023' => ['expected' => false, 'input' => 'あ1'],
            'pattern: 024' => ['expected' => false, 'input' => 'ａ1'],
            'pattern: 025' => ['expected' => false, 'input' => 'Ａ1'],
            'pattern: 026' => ['expected' => false, 'input' => '１1'],
            // 例外パターン
            'pattern: 027' => ['expected' => false, 'input' => ''],
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
            'pattern: 001' => ['expected' => false, 'input' => 'あ'],
            'pattern: 002' => ['expected' => false, 'input' => 'ａ'],
            'pattern: 003' => ['expected' => false, 'input' => 'Ａ'],
            'pattern: 004' => ['expected' => false, 'input' => '１'],
            // 半角1字
            'pattern: 005' => ['expected' => true, 'input' => 'a'],
            'pattern: 006' => ['expected' => true, 'input' => 'A'],
            'pattern: 007' => ['expected' => true, 'input' => '1'],
            // 全角2字以上
            'pattern: 008' => ['expected' => false, 'input' => 'あい'],
            'pattern: 009' => ['expected' => false, 'input' => 'ａｉ'],
            'pattern: 010' => ['expected' => false, 'input' => 'ＡＩ'],
            'pattern: 011' => ['expected' => false, 'input' => '１２'],
            // 半角2字以上
            'pattern: 012' => ['expected' => true, 'input' => 'ab'],
            'pattern: 013' => ['expected' => true, 'input' => 'AB'],
            'pattern: 014' => ['expected' => true, 'input' => '12'],
            // 全角半角混同（英小文字）
            'pattern: 015' => ['expected' => true, 'input' => 'あa'],
            'pattern: 016' => ['expected' => true, 'input' => 'ａa'],
            'pattern: 017' => ['expected' => true, 'input' => 'Ａa'],
            'pattern: 018' => ['expected' => true, 'input' => '１a'],
            // 全角半角混同（英大文字）
            'pattern: 019' => ['expected' => true, 'input' => 'あA'],
            'pattern: 020' => ['expected' => true, 'input' => 'ａA'],
            'pattern: 021' => ['expected' => true, 'input' => 'ＡA'],
            'pattern: 022' => ['expected' => true, 'input' => '１A'],
            // 全角半角混同（英数字）
            'pattern: 023' => ['expected' => true, 'input' => 'あ1'],
            'pattern: 024' => ['expected' => true, 'input' => 'ａ1'],
            'pattern: 025' => ['expected' => true, 'input' => 'Ａ1'],
            'pattern: 026' => ['expected' => true, 'input' => '１1'],
            // 例外パターン
            'pattern: 027' => ['expected' => true, 'input' => ''],
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
