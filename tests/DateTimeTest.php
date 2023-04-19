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
 * * *
 * @see \Selen\DateTime
 *
 * @internal
 */
class DateTimeTest extends TestCase
{
    public function dataProviderConstruct()
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
    public function testConstruct($expected, $input)
    {
        $this->assertInstanceOf($expected, new DateTime($input));
    }

    public function dataProviderParseStr()
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
    public function testParseStr($expected, $input)
    {
        $this->assertInstanceOf($expected, DateTime::parseStr(...$input));
    }

    public function dataProviderParseInt()
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
    public function testParseInt($expected, $input)
    {
        $this->assertInstanceOf($expected, DateTime::parseInt($input));
    }
}
