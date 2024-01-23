<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Bool;

use PHPUnit\Framework\TestCase;
use Selen\Bool\Util;

/**
 * @coversDefaultClass \Selen\Bool\Util
 *
 * @see Util
 *
 * @internal
 */
class UtilTest extends TestCase
{
    public function dataProviderToString()
    {
        return [
            'pattern001' => ['expected' => 'true',  'input' => true],
            'pattern002' => ['expected' => 'false', 'input' => false],
        ];
    }

    /**
     * @dataProvider dataProviderToString
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToString($expected, $input)
    {
        $this->assertSame($expected, Util::toString($input));
    }

    public function dataProviderOneTrue()
    {
        return [
            'pattern001' => ['expected' => true,    'input' => [true]],
            'pattern002' => ['expected' => false,   'input' => [false]],
            'pattern003' => ['expected' => false,   'input' => [true, true]],
            'pattern004' => ['expected' => true,    'input' => [true, false]],
            'pattern005' => ['expected' => false,   'input' => [false, false]],
            'pattern006' => ['expected' => false,   'input' => [true, true, true]],
            'pattern007' => ['expected' => false,   'input' => [true, true, false]],
            'pattern008' => ['expected' => true,    'input' => [true, false, false]],
            'pattern009' => ['expected' => false,   'input' => [false, false, false]],
        ];
    }

    /**
     * @dataProvider dataProviderOneTrue
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testOneTrue($expected, $input)
    {
        $this->assertSame($expected, Util::oneTrue(...$input));
    }

    public function dataProviderOneFalse()
    {
        return [
            'pattern001' => ['expected' => false,   'input' => [true]],
            'pattern002' => ['expected' => true,    'input' => [false]],
            'pattern003' => ['expected' => false,   'input' => [true, true]],
            'pattern004' => ['expected' => true,    'input' => [true, false]],
            'pattern005' => ['expected' => false,   'input' => [false, false]],
            'pattern006' => ['expected' => false,   'input' => [true, true, true]],
            'pattern007' => ['expected' => true,    'input' => [true, true, false]],
            'pattern008' => ['expected' => false,   'input' => [true, false, false]],
            'pattern009' => ['expected' => false,   'input' => [false, false, false]],
        ];
    }

    /**
     * @dataProvider dataProviderOneFalse
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testOneFalse($expected, $input)
    {
        $this->assertSame($expected, Util::oneFalse(...$input));
    }

    public function dataProviderAnyTrue()
    {
        return [
            'pattern001' => ['expected' => true,    'input' => [true]],
            'pattern002' => ['expected' => false,   'input' => [false]],
            'pattern003' => ['expected' => true,    'input' => [true, true]],
            'pattern004' => ['expected' => true,    'input' => [true, false]],
            'pattern005' => ['expected' => false,   'input' => [false, false]],
            'pattern006' => ['expected' => true,    'input' => [true, true, true]],
            'pattern007' => ['expected' => true,    'input' => [true, true, false]],
            'pattern008' => ['expected' => true,    'input' => [true, false, false]],
            'pattern009' => ['expected' => false,   'input' => [false, false, false]],
        ];
    }

    /**
     * @dataProvider dataProviderAnyTrue
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testAnyTrue($expected, $input)
    {
        $this->assertSame($expected, Util::anyTrue(...$input));
    }

    public function dataProviderAnyFalse()
    {
        return [
            'pattern001' => ['expected' => false,   'input' => [true]],
            'pattern002' => ['expected' => true,    'input' => [false]],
            'pattern003' => ['expected' => false,   'input' => [true, true]],
            'pattern004' => ['expected' => true,    'input' => [true, false]],
            'pattern005' => ['expected' => true,    'input' => [false, false]],
            'pattern006' => ['expected' => false,   'input' => [true, true, true]],
            'pattern007' => ['expected' => true,    'input' => [true, true, false]],
            'pattern008' => ['expected' => true,    'input' => [true, false, false]],
            'pattern009' => ['expected' => true,    'input' => [false, false, false]],
        ];
    }

    /**
     * @dataProvider dataProviderAnyFalse
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testAnyFalse($expected, $input)
    {
        $this->assertSame($expected, Util::anyFalse(...$input));
    }

    public function dataProviderAllTrue()
    {
        return [
            'pattern001' => ['expected' => true,    'input' => [true]],
            'pattern002' => ['expected' => false,   'input' => [false]],
            'pattern003' => ['expected' => true,    'input' => [true, true]],
            'pattern004' => ['expected' => false,   'input' => [true, false]],
            'pattern005' => ['expected' => false,   'input' => [false, false]],
            'pattern006' => ['expected' => true,    'input' => [true, true, true]],
            'pattern007' => ['expected' => false,   'input' => [true, true, false]],
            'pattern008' => ['expected' => false,   'input' => [true, false, false]],
            'pattern009' => ['expected' => false,   'input' => [false, false, false]],
        ];
    }

    /**
     * @dataProvider dataProviderAllTrue
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testAllTrue($expected, $input)
    {
        $this->assertSame($expected, Util::allTrue(...$input));
    }

    public function dataProviderAllFalse()
    {
        return [
            'pattern001' => ['expected' => false,   'input' => [true]],
            'pattern002' => ['expected' => true,    'input' => [false]],
            'pattern003' => ['expected' => false,   'input' => [true, true]],
            'pattern004' => ['expected' => false,   'input' => [true, false]],
            'pattern005' => ['expected' => true,    'input' => [false, false]],
            'pattern006' => ['expected' => false,   'input' => [true, true, true]],
            'pattern007' => ['expected' => false,   'input' => [true, true, false]],
            'pattern008' => ['expected' => false,   'input' => [true, false, false]],
            'pattern009' => ['expected' => true,    'input' => [false, false, false]],
        ];
    }

    /**
     * @dataProvider dataProviderAllFalse
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testAllFalse($expected, $input)
    {
        $this->assertSame($expected, Util::allFalse(...$input));
    }
}
