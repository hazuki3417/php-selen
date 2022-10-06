<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Str;

use PHPUnit\Framework\TestCase;
use Selen\Str\Alphabet;

/**
 * @coversDefaultClass \Selen\Str\Alphabet
 *
 * @group Selen/Str
 * @group Selen/Str/Alphabet
 *
 * @see \Selen\Str\Alphabet
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Str/Alphabet
 *
 * @internal
 */
class AlphabetTest extends TestCase
{
    public function dataProviderGetLowerCase26Ary()
    {
        return [
            'pattern001' => ['expected' => 'a', 'input' => '0'],
            'pattern002' => ['expected' => 'b', 'input' => '1'],
            'pattern003' => ['expected' => 'c', 'input' => '2'],
            'pattern004' => ['expected' => 'd', 'input' => '3'],
            'pattern005' => ['expected' => 'e', 'input' => '4'],
            'pattern006' => ['expected' => 'f', 'input' => '5'],
            'pattern007' => ['expected' => 'g', 'input' => '6'],
            'pattern008' => ['expected' => 'h', 'input' => '7'],
            'pattern009' => ['expected' => 'i', 'input' => '8'],
            'pattern010' => ['expected' => 'j', 'input' => '9'],
            'pattern011' => ['expected' => 'k', 'input' => 'A'],
            'pattern012' => ['expected' => 'l', 'input' => 'B'],
            'pattern013' => ['expected' => 'm', 'input' => 'C'],
            'pattern014' => ['expected' => 'n', 'input' => 'D'],
            'pattern015' => ['expected' => 'o', 'input' => 'E'],
            'pattern016' => ['expected' => 'p', 'input' => 'F'],
            'pattern017' => ['expected' => 'q', 'input' => 'G'],
            'pattern018' => ['expected' => 'r', 'input' => 'H'],
            'pattern019' => ['expected' => 's', 'input' => 'I'],
            'pattern020' => ['expected' => 't', 'input' => 'J'],
            'pattern021' => ['expected' => 'u', 'input' => 'K'],
            'pattern022' => ['expected' => 'v', 'input' => 'L'],
            'pattern023' => ['expected' => 'w', 'input' => 'M'],
            'pattern024' => ['expected' => 'x', 'input' => 'N'],
            'pattern025' => ['expected' => 'y', 'input' => 'O'],
            'pattern026' => ['expected' => 'z', 'input' => 'P'],
            // 小文字のアルファベット指定も可能
            'pattern027' => ['expected' => 'k', 'input' => 'a'],
            'pattern028' => ['expected' => 'l', 'input' => 'b'],
            'pattern029' => ['expected' => 'm', 'input' => 'c'],
            'pattern030' => ['expected' => 'n', 'input' => 'd'],
            'pattern031' => ['expected' => 'o', 'input' => 'e'],
            'pattern032' => ['expected' => 'p', 'input' => 'f'],
            'pattern033' => ['expected' => 'q', 'input' => 'g'],
            'pattern034' => ['expected' => 'r', 'input' => 'h'],
            'pattern035' => ['expected' => 's', 'input' => 'i'],
            'pattern036' => ['expected' => 't', 'input' => 'j'],
            'pattern037' => ['expected' => 'u', 'input' => 'k'],
            'pattern038' => ['expected' => 'v', 'input' => 'l'],
            'pattern039' => ['expected' => 'w', 'input' => 'm'],
            'pattern040' => ['expected' => 'x', 'input' => 'n'],
            'pattern041' => ['expected' => 'y', 'input' => 'o'],
            'pattern042' => ['expected' => 'z', 'input' => 'p'],
        ];
    }

    /**
     * @dataProvider dataProviderGetLowerCase26Ary
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetLowerCase26Ary($expected, $input)
    {
        $this->assertSame($expected, Alphabet::getLowerCase26Ary($input));
    }

    /**
     * 想定外の値を指定.
     */
    public function testGetLowerCase26AryException1()
    {
        $this->expectException(\InvalidArgumentException::class);

        Alphabet::getLowerCase26Ary('-1');
    }

    /**
     * 範囲外を指定.
     */
    public function testGetLowerCase26AryException2()
    {
        $this->expectException(\RuntimeException::class);

        Alphabet::getLowerCase26Ary('10');
    }

    public function dataProviderGetUpperCase26Ary()
    {
        return [
            'pattern001' => ['expected' => 'A', 'input' => '0'],
            'pattern002' => ['expected' => 'B', 'input' => '1'],
            'pattern003' => ['expected' => 'C', 'input' => '2'],
            'pattern004' => ['expected' => 'D', 'input' => '3'],
            'pattern005' => ['expected' => 'E', 'input' => '4'],
            'pattern006' => ['expected' => 'F', 'input' => '5'],
            'pattern007' => ['expected' => 'G', 'input' => '6'],
            'pattern008' => ['expected' => 'H', 'input' => '7'],
            'pattern009' => ['expected' => 'I', 'input' => '8'],
            'pattern010' => ['expected' => 'J', 'input' => '9'],
            'pattern011' => ['expected' => 'K', 'input' => 'A'],
            'pattern012' => ['expected' => 'L', 'input' => 'B'],
            'pattern013' => ['expected' => 'M', 'input' => 'C'],
            'pattern014' => ['expected' => 'N', 'input' => 'D'],
            'pattern015' => ['expected' => 'O', 'input' => 'E'],
            'pattern016' => ['expected' => 'P', 'input' => 'F'],
            'pattern017' => ['expected' => 'Q', 'input' => 'G'],
            'pattern018' => ['expected' => 'R', 'input' => 'H'],
            'pattern019' => ['expected' => 'S', 'input' => 'I'],
            'pattern020' => ['expected' => 'T', 'input' => 'J'],
            'pattern021' => ['expected' => 'U', 'input' => 'K'],
            'pattern022' => ['expected' => 'V', 'input' => 'L'],
            'pattern023' => ['expected' => 'W', 'input' => 'M'],
            'pattern024' => ['expected' => 'X', 'input' => 'N'],
            'pattern025' => ['expected' => 'Y', 'input' => 'O'],
            'pattern026' => ['expected' => 'Z', 'input' => 'P'],
            // 小文字のアルファベット指定も可能
            'pattern027' => ['expected' => 'K', 'input' => 'a'],
            'pattern028' => ['expected' => 'L', 'input' => 'b'],
            'pattern029' => ['expected' => 'M', 'input' => 'c'],
            'pattern030' => ['expected' => 'N', 'input' => 'd'],
            'pattern031' => ['expected' => 'O', 'input' => 'e'],
            'pattern032' => ['expected' => 'P', 'input' => 'f'],
            'pattern033' => ['expected' => 'Q', 'input' => 'g'],
            'pattern034' => ['expected' => 'R', 'input' => 'h'],
            'pattern035' => ['expected' => 'S', 'input' => 'i'],
            'pattern036' => ['expected' => 'T', 'input' => 'j'],
            'pattern037' => ['expected' => 'U', 'input' => 'k'],
            'pattern038' => ['expected' => 'V', 'input' => 'l'],
            'pattern039' => ['expected' => 'W', 'input' => 'm'],
            'pattern040' => ['expected' => 'X', 'input' => 'n'],
            'pattern041' => ['expected' => 'Y', 'input' => 'o'],
            'pattern042' => ['expected' => 'Z', 'input' => 'p'],
        ];
    }

    /**
     * @dataProvider dataProviderGetUpperCase26Ary
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetUpperCase26Ary($expected, $input)
    {
        $this->assertSame($expected, Alphabet::getUpperCase26Ary($input));
    }

    /**
     * 想定外の値を指定.
     */
    public function testGetUpperCase26AryException1()
    {
        $this->expectException(\InvalidArgumentException::class);

        Alphabet::getUpperCase26Ary('-1');
    }

    /**
     * 範囲外を指定.
     */
    public function testGetUpperCase26AryException2()
    {
        $this->expectException(\RuntimeException::class);

        Alphabet::getUpperCase26Ary('10');
    }
}
