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
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderToString(): array
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
    public function testToString($expected, $input): void
    {
        $this->assertSame($expected, Util::toString($input));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderOneTrue(): array
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
    public function testOneTrue($expected, $input): void
    {
        $this->assertSame($expected, Util::oneTrue(...$input));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderOneFalse(): array
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
    public function testOneFalse($expected, $input): void
    {
        $this->assertSame($expected, Util::oneFalse(...$input));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderAnyTrue(): array
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
    public function testAnyTrue($expected, $input): void
    {
        $this->assertSame($expected, Util::anyTrue(...$input));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderAnyFalse(): array
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
    public function testAnyFalse($expected, $input): void
    {
        $this->assertSame($expected, Util::anyFalse(...$input));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderAllTrue(): array
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
    public function testAllTrue($expected, $input): void
    {
        $this->assertSame($expected, Util::allTrue(...$input));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderAllFalse(): array
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
    public function testAllFalse($expected, $input): void
    {
        $this->assertSame($expected, Util::allFalse(...$input));
    }
}
