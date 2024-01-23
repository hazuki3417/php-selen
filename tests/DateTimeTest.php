<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen;

use PHPUnit\Framework\TestCase;
use Selen\DateTime;
use Selen\DateTime\Record;

/**
 * @coversDefaultClass \Selen\DateTime
 *
 * @see DateTime
 *
 * @internal
 */
class DateTimeTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderConstruct(): array
    {
        return [
            'validPattern: 001' => [
                'expected' => DateTime::class,
                'input'    => new Record(),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderConstruct
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testConstruct($expected, $input): void
    {
        $this->assertInstanceOf($expected, new DateTime($input));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderParseStr(): array
    {
        return [
            'validPattern: 001' => [
                'expected' => DateTime::class,
                'input'    => [
                    'parseFormat' => 'Y-m-d',
                    'dateTime'    => '2023-04-19',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderParseStr
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testParseStr($expected, $input): void
    {
        $this->assertInstanceOf($expected, DateTime::parseStr(...$input));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderParseInt(): array
    {
        return [
            'validPattern: 001' => [
                'expected' => DateTime::class,
                'input'    => time(),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderParseInt
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testParseInt($expected, $input): void
    {
        $this->assertInstanceOf($expected, DateTime::parseInt($input));
    }
}
