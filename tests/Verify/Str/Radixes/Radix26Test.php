<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str\Radixes\Test;

use PHPUnit\Framework\TestCase;
use Selen\Verify\Str\Radixes\Radix26;

/**
 * @coversDefaultClass \Selen\Verify\Str\Radixes\Radix26
 *
 * @group Selen/Verify/Str/Radixes
 * @group Selen/Verify/Str/Radixes/Radix26
 *
 * @see \Selen\Verify\Str\Radixes\Radix26
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Verify/Str/Radixes/Radix26
 *
 * @internal
 */
class Radix26Test extends TestCase
{
    public function dataProviderVerify()
    {
        return [
            // 26進数で使える文字（数字）
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

            // 26進数で使える文字（アルファベット小文字）
            'pattern011' => ['expected' => true, 'input' => 'a'],
            'pattern012' => ['expected' => true, 'input' => 'b'],
            'pattern013' => ['expected' => true, 'input' => 'c'],
            'pattern014' => ['expected' => true, 'input' => 'd'],
            'pattern015' => ['expected' => true, 'input' => 'e'],
            'pattern016' => ['expected' => true, 'input' => 'f'],
            'pattern017' => ['expected' => true, 'input' => 'g'],
            'pattern018' => ['expected' => true, 'input' => 'h'],
            'pattern019' => ['expected' => true, 'input' => 'i'],
            'pattern020' => ['expected' => true, 'input' => 'j'],
            'pattern021' => ['expected' => true, 'input' => 'k'],
            'pattern022' => ['expected' => true, 'input' => 'l'],
            'pattern023' => ['expected' => true, 'input' => 'm'],
            'pattern024' => ['expected' => true, 'input' => 'n'],
            'pattern025' => ['expected' => true, 'input' => 'o'],
            'pattern026' => ['expected' => true, 'input' => 'p'],

            // 26進数で使えない文字（アルファベット小文字）
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

            // 26進数で使える文字（アルファベット大文字）
            'pattern037' => ['expected' => true, 'input' => 'A'],
            'pattern038' => ['expected' => true, 'input' => 'B'],
            'pattern039' => ['expected' => true, 'input' => 'C'],
            'pattern040' => ['expected' => true, 'input' => 'D'],
            'pattern041' => ['expected' => true, 'input' => 'E'],
            'pattern042' => ['expected' => true, 'input' => 'F'],
            'pattern043' => ['expected' => true, 'input' => 'G'],
            'pattern044' => ['expected' => true, 'input' => 'H'],
            'pattern045' => ['expected' => true, 'input' => 'I'],
            'pattern046' => ['expected' => true, 'input' => 'J'],
            'pattern047' => ['expected' => true, 'input' => 'K'],
            'pattern048' => ['expected' => true, 'input' => 'L'],
            'pattern049' => ['expected' => true, 'input' => 'M'],
            'pattern050' => ['expected' => true, 'input' => 'N'],
            'pattern051' => ['expected' => true, 'input' => 'O'],
            'pattern052' => ['expected' => true, 'input' => 'P'],

            // 26進数で使えない文字（アルファベット大文字）
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

            // 26進数で使えない文字（想定外の文字）
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

            // 26進数形式の文字列をチェックできるかテスト
            'pattern073' => ['expected' => true, 'input' => '0123456789abcdefghijklmnop'],
            'pattern074' => ['expected' => true, 'input' => '0123456789ABCDEFGHIJKLMNOP'],

            'pattern075' => ['expected' => false, 'input' => '0123456789abcdefghijklmnopq'],
            'pattern076' => ['expected' => false, 'input' => '0123456789ABCDEFGHIJKLMNOPQ'],
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
        $this->assertEquals($expected, Radix26::verify($input));
    }
}
