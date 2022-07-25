<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str\Radixes\Test;

use PHPUnit\Framework\TestCase;
use Selen\Verify\Str\Radixes\Radix3;

/**
 * @coversDefaultClass \Selen\Verify\Str\Radixes\Radix3
 *
 * @group Selen/Verify/Str/Radixes
 * @group Selen/Verify/Str/Radixes/Radix3
 *
 * @see \Selen\Verify\Str\Radixes\Radix3
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Verify/Str/Radixes/Radix3
 *
 * @internal
 */
class Radix3Test extends TestCase
{
    public function dataProviderVerify()
    {
        return [
            // 3進数で使える文字（数字）
            'pattern001' => ['expected' => true, 'input' => '0'],
            'pattern002' => ['expected' => true, 'input' => '1'],
            'pattern003' => ['expected' => true, 'input' => '2'],

            // 3進数で使えない文字（数字）
            'pattern004' => ['expected' => false, 'input' => '3'],
            'pattern005' => ['expected' => false, 'input' => '4'],
            'pattern006' => ['expected' => false, 'input' => '5'],
            'pattern007' => ['expected' => false, 'input' => '6'],
            'pattern008' => ['expected' => false, 'input' => '7'],
            'pattern009' => ['expected' => false, 'input' => '8'],
            'pattern010' => ['expected' => false, 'input' => '9'],

            // 3進数で使えない文字（アルファベット小文字）
            'pattern011' => ['expected' => false, 'input' => 'a'],
            'pattern012' => ['expected' => false, 'input' => 'b'],
            'pattern013' => ['expected' => false, 'input' => 'c'],
            'pattern014' => ['expected' => false, 'input' => 'd'],
            'pattern015' => ['expected' => false, 'input' => 'e'],
            'pattern016' => ['expected' => false, 'input' => 'f'],
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

            // 3進数で使えない文字（アルファベット大文字）
            'pattern037' => ['expected' => false, 'input' => 'a'],
            'pattern038' => ['expected' => false, 'input' => 'b'],
            'pattern039' => ['expected' => false, 'input' => 'c'],
            'pattern040' => ['expected' => false, 'input' => 'd'],
            'pattern041' => ['expected' => false, 'input' => 'e'],
            'pattern042' => ['expected' => false, 'input' => 'f'],
            'pattern043' => ['expected' => false, 'input' => 'g'],
            'pattern044' => ['expected' => false, 'input' => 'h'],
            'pattern045' => ['expected' => false, 'input' => 'i'],
            'pattern046' => ['expected' => false, 'input' => 'j'],
            'pattern047' => ['expected' => false, 'input' => 'k'],
            'pattern048' => ['expected' => false, 'input' => 'l'],
            'pattern049' => ['expected' => false, 'input' => 'm'],
            'pattern050' => ['expected' => false, 'input' => 'n'],
            'pattern051' => ['expected' => false, 'input' => 'o'],
            'pattern052' => ['expected' => false, 'input' => 'p'],
            'pattern053' => ['expected' => false, 'input' => 'q'],
            'pattern054' => ['expected' => false, 'input' => 'r'],
            'pattern055' => ['expected' => false, 'input' => 's'],
            'pattern056' => ['expected' => false, 'input' => 't'],
            'pattern057' => ['expected' => false, 'input' => 'u'],
            'pattern058' => ['expected' => false, 'input' => 'v'],
            'pattern059' => ['expected' => false, 'input' => 'w'],
            'pattern060' => ['expected' => false, 'input' => 'x'],
            'pattern061' => ['expected' => false, 'input' => 'y'],
            'pattern062' => ['expected' => false, 'input' => 'z'],

            // 3進数で使えない文字（想定外の文字）
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

            // 3進数形式の文字列をチェックできるかテスト
            'pattern073' => ['expected' => true, 'input' => '012'],

            'pattern074' => ['expected' => false, 'input' => '0123'],
            'pattern075' => ['expected' => false, 'input' => '012a'],
            'pattern076' => ['expected' => false, 'input' => '012A'],
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
        $this->assertEquals($expected, Radix3::verify($input));
    }
}
