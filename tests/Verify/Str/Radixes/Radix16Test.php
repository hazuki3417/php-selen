<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str\Radixes\Test;

use PHPUnit\Framework\TestCase;
use Selen\Verify\Str\Radixes\Radix16;

/**
 * @coversDefaultClass \Selen\Verify\Str\Radixes\Radix16
 *
 * @group Selen/Verify/Str/Radixes
 * @group Selen/Verify/Str/Radixes/Radix16
 *
 * @see \Selen\Verify\Str\Radixes\Radix16
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Verify/Str/Radixes/Radix16
 *
 * @internal
 */
class Radix16Test extends TestCase
{
    public function dataProviderVerify()
    {
        return [
            // 16進数で使える文字（数字）
            'pattern001' => ['expected' => true, 'input' => '0'],
            'pattern002' => ['expected' => true, 'input' => '1'],
            'pattern003' => ['expected' => true, 'input' => '2'],
            'pattern004' => ['expected' => true, 'input' => '3'],
            'pattern005' => ['expected' => true, 'input' => '4'],
            'pattern006' => ['expected' => true, 'input' => '5'],
            'pattern007' => ['expected' => true, 'input' => '6'],
            'pattern008' => ['expected' => true, 'input' => '7'],
            'pattern009' => ['expected' => true, 'input' => '8'],
            'pattern010' => ['expected' => true, 'input' => '9'],

            // 16進数で使える文字（アルファベット小文字）
            'pattern011' => ['expected' => true, 'input' => 'a'],
            'pattern012' => ['expected' => true, 'input' => 'b'],
            'pattern013' => ['expected' => true, 'input' => 'c'],
            'pattern014' => ['expected' => true, 'input' => 'd'],
            'pattern015' => ['expected' => true, 'input' => 'e'],
            'pattern016' => ['expected' => true, 'input' => 'f'],

            // 16進数で使えない文字（アルファベット小文字）
            'pattern017' => ['expected' => false, 'input' => 'g'],
            'pattern018' => ['expected' => false, 'input' => 'h'],
            'pattern019' => ['expected' => false, 'input' => 'i'],
            'pattern020' => ['expected' => false, 'input' => 'j'],
            'pattern021' => ['expected' => false, 'input' => 'k'],
            'pattern022' => ['expected' => false, 'input' => 'l'],
            'pattern023' => ['expected' => false, 'input' => 'm'],
            'pattern024' => ['expected' => false, 'input' => 'n'],
            'pattern025' => ['expected' => false, 'input' => 'o'],
            'pattern026' => ['expected' => false, 'input' => 'p'],
            'pattern027' => ['expected' => false, 'input' => 'q'],
            'pattern028' => ['expected' => false, 'input' => 'r'],
            'pattern029' => ['expected' => false, 'input' => 's'],
            'pattern030' => ['expected' => false, 'input' => 't'],
            'pattern031' => ['expected' => false, 'input' => 'u'],
            'pattern032' => ['expected' => false, 'input' => 'v'],
            'pattern033' => ['expected' => false, 'input' => 'w'],
            'pattern034' => ['expected' => false, 'input' => 'x'],
            'pattern035' => ['expected' => false, 'input' => 'y'],
            'pattern036' => ['expected' => false, 'input' => 'z'],

            // 16進数で使える文字（アルファベット大文字）
            'pattern037' => ['expected' => true, 'input' => 'A'],
            'pattern038' => ['expected' => true, 'input' => 'B'],
            'pattern039' => ['expected' => true, 'input' => 'C'],
            'pattern040' => ['expected' => true, 'input' => 'D'],
            'pattern041' => ['expected' => true, 'input' => 'E'],
            'pattern042' => ['expected' => true, 'input' => 'F'],

            // 16進数で使えない文字（アルファベット大文字）
            'pattern043' => ['expected' => false, 'input' => 'G'],
            'pattern044' => ['expected' => false, 'input' => 'H'],
            'pattern045' => ['expected' => false, 'input' => 'I'],
            'pattern046' => ['expected' => false, 'input' => 'J'],
            'pattern047' => ['expected' => false, 'input' => 'K'],
            'pattern048' => ['expected' => false, 'input' => 'L'],
            'pattern049' => ['expected' => false, 'input' => 'M'],
            'pattern050' => ['expected' => false, 'input' => 'N'],
            'pattern051' => ['expected' => false, 'input' => 'O'],
            'pattern052' => ['expected' => false, 'input' => 'P'],
            'pattern053' => ['expected' => false, 'input' => 'Q'],
            'pattern054' => ['expected' => false, 'input' => 'R'],
            'pattern055' => ['expected' => false, 'input' => 'S'],
            'pattern056' => ['expected' => false, 'input' => 'T'],
            'pattern057' => ['expected' => false, 'input' => 'U'],
            'pattern058' => ['expected' => false, 'input' => 'V'],
            'pattern059' => ['expected' => false, 'input' => 'W'],
            'pattern060' => ['expected' => false, 'input' => 'X'],
            'pattern061' => ['expected' => false, 'input' => 'Y'],
            'pattern062' => ['expected' => false, 'input' => 'Z'],

            // 16進数で使えない文字（想定外の文字）
            'pattern063' => ['expected' => false, 'input' => ''],
            'pattern064' => ['expected' => false, 'input' => '-1'],
            'pattern065' => ['expected' => false, 'input' => '０'],
            'pattern066' => ['expected' => false, 'input' => '-'],
            'pattern067' => ['expected' => false, 'input' => '_'],
            'pattern068' => ['expected' => false, 'input' => 'あ'],
            'pattern069' => ['expected' => false, 'input' => 'ア'],
            'pattern070' => ['expected' => false, 'input' => 'ｱ'],
            'pattern071' => ['expected' => false, 'input' => '亜'],
            'pattern072' => ['expected' => false, 'input' => '亜'],

            // 16進数形式の文字列をチェックできるかテスト
            'pattern073' => ['expected' => true, 'input' => '0123456789abcdef'],
            'pattern074' => ['expected' => true, 'input' => '0123456789ABCDEF'],

            'pattern075' => ['expected' => false, 'input' => '0123456789abcdefg'],
            'pattern076' => ['expected' => false, 'input' => '0123456789ABCDEFG'],
        ];
    }

    /**
     * @dataProvider dataProviderVerify
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testVerify($expected, $input)
    {
        $this->assertSame($expected, Radix16::verify($input));
    }
}
