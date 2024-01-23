<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Verify\Str;

use LogicException;
use PHPUnit\Framework\TestCase;
use Selen\Str\Verify\Length;

/**
 * @coversDefaultClass \Selen\Str\Verify\Length
 *
 * @see Length
 *
 * @internal
 */
class LengthTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Length::class, Length::set(''));
    }

    public function dataProviderCount()
    {
        return [
            // 全角1字
            'pattern001' => ['expected' => 1, 'testVal' => 'あ'],
            'pattern002' => ['expected' => 1, 'testVal' => 'ａ'],
            'pattern003' => ['expected' => 1, 'testVal' => 'Ａ'],
            'pattern004' => ['expected' => 1, 'testVal' => '１'],
            // 半角1字
            'pattern005' => ['expected' => 1, 'testVal' => 'a'],
            'pattern006' => ['expected' => 1, 'testVal' => 'A'],
            'pattern007' => ['expected' => 1, 'testVal' => '1'],
            // 全角2字以上
            'pattern008' => ['expected' => 2, 'testVal' => 'あい'],
            'pattern009' => ['expected' => 2, 'testVal' => 'ａｉ'],
            'pattern010' => ['expected' => 2, 'testVal' => 'ＡＩ'],
            'pattern011' => ['expected' => 2, 'testVal' => '１２'],
            // 半角2字以上
            'pattern012' => ['expected' => 2, 'testVal' => 'ab'],
            'pattern013' => ['expected' => 2, 'testVal' => 'AB'],
            'pattern014' => ['expected' => 2, 'testVal' => '12'],
            // 全角半角混同
            'pattern015' => ['expected' => 2, 'testVal' => 'あa'],
            'pattern016' => ['expected' => 2, 'testVal' => 'ａa'],
            'pattern017' => ['expected' => 2, 'testVal' => 'Ａa'],
            'pattern018' => ['expected' => 2, 'testVal' => '１a'],
            // 空文字
            'pattern019' => ['expected' => 0, 'testVal' => ''],
        ];
    }

    /**
     * @dataProvider dataProviderCount
     *
     * @param mixed $expected
     * @param mixed $testVal
     */
    public function testCount($expected, $testVal)
    {
        $this->assertSame($expected, (Length::set($testVal))->count());
    }

    public function dataProviderGt()
    {
        return [
            // 空白文字のときのテスト
            'pattern001' => [
                'expected' => false,
                'testVal'  => ['set' => '', 'gt' => 0],
            ],
            // 1文字のときのテスト
            'pattern002' => [
                'expected' => true,
                'testVal'  => ['set' => 'a', 'gt' => 0],
            ],
            // 境界値テスト（半角文字）
            'pattern003' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'gt' => 4],
            ],
            'pattern004' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'gt' => 5],
            ],
            'pattern005' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'gt' => 6],
            ],
            // 境界値テスト（全角文字）
            'pattern006' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'gt' => 4],
            ],
            'pattern007' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'gt' => 5],
            ],
            'pattern008' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'gt' => 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGt
     *
     * @param mixed $expected
     * @param mixed $testVal
     */
    public function testGt($expected, $testVal)
    {
        $this->assertSame($expected, (Length::set($testVal['set']))->gt($testVal['gt']));
    }

    public function testGtException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Signed integers cannot be specified');
        Length::set('')->gt(-1);
    }

    public function dataProviderGe()
    {
        return [
            // 空白文字のときのテスト
            'pattern001' => [
                'expected' => true,
                'testVal'  => ['set' => '', 'ge' => 0],
            ],
            // 1文字のときのテスト
            'pattern002' => [
                'expected' => true,
                'testVal'  => ['set' => 'a', 'ge' => 0],
            ],
            // 境界値テスト（半角文字）
            'pattern003' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'ge' => 4],
            ],
            'pattern004' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'ge' => 5],
            ],
            'pattern005' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'ge' => 6],
            ],
            // 境界値テスト（全角文字）
            'pattern006' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'ge' => 4],
            ],
            'pattern007' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'ge' => 5],
            ],
            'pattern008' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'ge' => 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGe
     *
     * @param mixed $expected
     * @param mixed $testVal
     */
    public function testGe($expected, $testVal)
    {
        $this->assertSame($expected, (Length::set($testVal['set']))->ge($testVal['ge']));
    }

    public function testGeException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Signed integers cannot be specified');
        Length::set('')->ge(-1);
    }

    public function dataProviderLe()
    {
        return [
            // 空白文字のときのテスト
            'pattern001' => [
                'expected' => true,
                'testVal'  => ['set' => '', 'le' => 0],
            ],
            // 1文字のときのテスト
            'pattern002' => [
                'expected' => false,
                'testVal'  => ['set' => 'a', 'le' => 0],
            ],
            // 境界値テスト（半角文字）
            'pattern003' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'le' => 4],
            ],
            'pattern004' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'le' => 5],
            ],
            'pattern005' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'le' => 6],
            ],
            // 境界値テスト（全角文字）
            'pattern006' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'le' => 4],
            ],
            'pattern007' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'le' => 5],
            ],
            'pattern008' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'le' => 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderLe
     *
     * @param mixed $expected
     * @param mixed $testVal
     */
    public function testLe($expected, $testVal)
    {
        $this->assertSame($expected, (Length::set($testVal['set']))->le($testVal['le']));
    }

    public function testLeException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Signed integers cannot be specified');
        Length::set('')->le(-1);
    }

    public function dataProviderLt()
    {
        return [
            // 空白文字のときのテスト
            'pattern001' => [
                'expected' => false,
                'testVal'  => ['set' => '', 'lt' => 0],
            ],
            // 1文字のときのテスト
            'pattern002' => [
                'expected' => false,
                'testVal'  => ['set' => 'a', 'lt' => 0],
            ],
            // 境界値テスト（半角文字）
            'pattern003' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'lt' => 4],
            ],
            'pattern004' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'lt' => 5],
            ],
            'pattern005' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'lt' => 6],
            ],
            // 境界値テスト（全角文字）
            'pattern006' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'lt' => 4],
            ],
            'pattern007' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'lt' => 5],
            ],
            'pattern008' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'lt' => 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderLt
     *
     * @param mixed $expected
     * @param mixed $testVal
     */
    public function testLt($expected, $testVal)
    {
        $this->assertSame($expected, (Length::set($testVal['set']))->lt($testVal['lt']));
    }

    public function testLtException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Signed integers cannot be specified');
        Length::set('')->lt(-1);
    }

    public function dataProviderEqual()
    {
        return [
            // 空白文字のときのテスト
            'pattern001' => [
                'expected' => true,
                'testVal'  => ['set' => '', 'equal' => 0],
            ],
            // 1文字のときのテスト
            'pattern002' => [
                'expected' => false,
                'testVal'  => ['set' => '', 'equal' => 1],
            ],
            // 境界値テスト（半角文字）
            'pattern003' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'equal' => 4],
            ],
            'pattern004' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'equal' => 5],
            ],
            'pattern005' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'equal' => 6],
            ],
            // 境界値テスト（全角文字）
            'pattern006' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'equal' => 4],
            ],
            'pattern007' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'equal' => 5],
            ],
            'pattern008' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'equal' => 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderEqual
     *
     * @param mixed $expected
     * @param mixed $testVal
     */
    public function testEqual($expected, $testVal)
    {
        $this->assertSame($expected, (Length::set($testVal['set']))->equal($testVal['equal']));
    }

    public function testEqualException1()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Signed integers cannot be specified');
        Length::set('')->equal(-1);
    }

    public function dataProviderIn()
    {
        return [
            // 空白文字のときのテスト
            'pattern001' => [
                'expected' => true,
                'testVal'  => ['set' => '', 'min' => 0, 'max' => 1],
            ],
            // 1文字のときのテスト
            'pattern002' => [
                'expected' => true,
                'testVal'  => ['set' => 'a', 'min' => 0, 'max' => 1],
            ],
            // minの境界値テスト（半角文字）
            'pattern003' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'min' => 0, 'max' => 7],
            ],
            'pattern004' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'min' => 5, 'max' => 7],
            ],
            'pattern005' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'min' => 6, 'max' => 7],
            ],
            // min境界値テスト（全角文字）
            'pattern006' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'min' => 0, 'max' => 7],
            ],
            'pattern007' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'min' => 5, 'max' => 7],
            ],
            'pattern008' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'min' => 6, 'max' => 7],
            ],
            // maxの境界値テスト（半角文字）
            'pattern009' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'min' => 0, 'max' => 4],
            ],
            'pattern010' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'min' => 0, 'max' => 5],
            ],
            'pattern011' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'min' => 0, 'max' => 6],
            ],
            // max境界値テスト（全角文字）
            'pattern012' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'min' => 0, 'max' => 4],
            ],
            'pattern013' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'min' => 0, 'max' => 5],
            ],
            'pattern014' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'min' => 0, 'max' => 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderIn
     *
     * @param mixed $expected
     * @param mixed $testVal
     */
    public function testIn($expected, $testVal)
    {
        $this->assertSame(
            $expected,
            (Length::set($testVal['set']))->in($testVal['min'], $testVal['max'])
        );
    }

    public function testInException1()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Signed integers cannot be specified');
        Length::set('')->in(-1, 10);
    }

    public function testInException2()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Signed integers cannot be specified');
        Length::set('')->in(0, -1);
    }

    public function testInException3()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('A value greater than max cannot be specified for min');
        Length::set('')->in(10, 2);
    }

    public function dataProviderOut()
    {
        return [
            // 空白文字のときのテスト
            'pattern001' => [
                'expected' => false,
                'testVal'  => ['set' => '', 'min' => 0, 'max' => 1],
            ],
            // 1文字のときのテスト
            'pattern002' => [
                'expected' => false,
                'testVal'  => ['set' => 'a', 'min' => 0, 'max' => 1],
            ],
            // minの境界値テスト（半角文字）
            'pattern003' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'min' => 0, 'max' => 7],
            ],
            'pattern004' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'min' => 5, 'max' => 7],
            ],
            'pattern005' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'min' => 6, 'max' => 7],
            ],
            // min境界値テスト（全角文字）
            'pattern006' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'min' => 0, 'max' => 7],
            ],
            'pattern007' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'min' => 5, 'max' => 7],
            ],
            'pattern008' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'min' => 6, 'max' => 7],
            ],
            // maxの境界値テスト（半角文字）
            'pattern009' => [
                'expected' => true,
                'testVal'  => ['set' => 'abcde', 'min' => 0, 'max' => 4],
            ],
            'pattern010' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'min' => 0, 'max' => 5],
            ],
            'pattern011' => [
                'expected' => false,
                'testVal'  => ['set' => 'abcde', 'min' => 0, 'max' => 6],
            ],
            // max境界値テスト（全角文字）
            'pattern012' => [
                'expected' => true,
                'testVal'  => ['set' => 'あいうえお', 'min' => 0, 'max' => 4],
            ],
            'pattern013' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'min' => 0, 'max' => 5],
            ],
            'pattern014' => [
                'expected' => false,
                'testVal'  => ['set' => 'あいうえお', 'min' => 0, 'max' => 6],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderOut
     *
     * @param mixed $expected
     * @param mixed $testVal
     */
    public function testOut($expected, $testVal)
    {
        $this->assertSame(
            $expected,
            (Length::set($testVal['set']))->out($testVal['min'], $testVal['max'])
        );
    }

    public function testOutException1()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Signed integers cannot be specified');
        Length::set('')->out(-1, 10);
    }

    public function testOutException2()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Signed integers cannot be specified');
        Length::set('')->out(0, -1);
    }

    public function testOutException3()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('A value greater than max cannot be specified for min');
        Length::set('')->out(10, 2);
    }
}
