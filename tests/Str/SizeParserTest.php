<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Str;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Selen\Str\SizeParser;

/**
 * @coversDefaultClass \Selen\Str\SizeParser
 *
 * @see \Selen\Str\SizeParser
 *
 * @internal
 */
class SizeParserTest extends TestCase
{
    public function dataProviderToByte(): array
    {
        return [
            'testPattern: input is 0byte' => [
                'input'    => '0byte',
                'expected' => 0,
            ],
            'testPattern: input is 1kB' => [
                'input'    => '1kB',
                'expected' => pow(1000, 1),
            ],
            'testPattern: input is 3kB' => [
                'input'    => '3kB',
                'expected' => 3 * pow(1000, 1),
            ],
            'testPattern: input is 1KiB' => [
                'input'    => '1KiB',
                'expected' => pow(1024, 1),
            ],
            'testPattern: input is 3KiB' => [
                'input'    => '3KiB',
                'expected' => 3 * pow(1024, 1),
            ],
            'testPattern: input is 1MB' => [
                'input'    => '1MB',
                'expected' => pow(1000, 2),
            ],
            'testPattern: input is 3MB' => [
                'input'    => '3MB',
                'expected' => 3 * pow(1000, 2),
            ],
            'testPattern: input is 1MiB' => [
                'input'    => '1MiB',
                'expected' => pow(1024, 2),
            ],
            'testPattern: input is 3MiB' => [
                'input'    => '3MiB',
                'expected' => 3 * pow(1024, 2),
            ],
            'testPattern: input is 1GB' => [
                'input'    => '1GB',
                'expected' => pow(1000, 3),
            ],
            'testPattern: input is 3GB' => [
                'input'    => '3GB',
                'expected' => 3 * pow(1000, 3),
            ],
            'testPattern: input is 1GiB' => [
                'input'    => '1GiB',
                'expected' => pow(1024, 3),
            ],
            'testPattern: input is 3GiB' => [
                'input'    => '3GiB',
                'expected' => 3 * pow(1024, 3),
            ],
            'testPattern: input is 1TB' => [
                'input'    => '1TB',
                'expected' => pow(1000, 4),
            ],
            'testPattern: input is 3TB' => [
                'input'    => '3TB',
                'expected' => 3 * pow(1000, 4),
            ],
            'testPattern: input is 1TiB' => [
                'input'    => '1TiB',
                'expected' => pow(1024, 4),
            ],
            'testPattern: input is 3TiB' => [
                'input'    => '3TiB',
                'expected' => 3 * pow(1024, 4),
            ],
            // これより先の値変換は利用想定が少ないのでテストは軽めに実施
            'testPattern: input is 1PB' => [
                'input'    => '1PB',
                'expected' => pow(1000, 5),
            ],
            'testPattern: input is 1EB' => [
                'input'    => '1EB',
                'expected' => pow(1000, 6),
            ],
            'testPattern: input is 1ZB' => [
                'input'    => '1ZB',
                'expected' => pow(1000, 7),
            ],
            'testPattern: input is 1YB' => [
                'input'    => '1YB',
                'expected' => pow(1000, 8),
            ],
            'testPattern: input is 1RB' => [
                'input'    => '1RB',
                'expected' => pow(1000, 9),
            ],
            'testPattern: input is 1QB' => [
                'input'    => '1QB',
                'expected' => pow(1000, 10),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderToByte
     *
     * @param mixed $input
     * @param mixed $expected
     */
    public function testToByte($input, $expected): void
    {
        $this->assertSame($expected, SizeParser::toByte($input));
    }

    public function dataProviderParse(): array
    {
        return [
            'testPattern: input is 0byte' => [
                'input'    => '0byte',
                'expected' => ['value' => 0, 'unit' => 'byte'],
            ],
            'testPattern: input is 1024B' => [
                'input'    => '1024byte',
                'expected' => ['value' => 1024, 'unit' => 'byte'],
            ],
            'testPattern: input is 1MB' => [
                'input'    => '1MB',
                'expected' => ['value' => 1, 'unit' => 'MB'],
            ],
            'testPattern: input is 1MiB' => [
                'input'    => '1MiB',
                'expected' => ['value' => 1, 'unit' => 'MiB'],
            ],
            'testPattern: input is 1GB' => [
                'input'    => '1GB',
                'expected' => ['value' => 1, 'unit' => 'GB'],
            ],
            'testPattern: input is 1GiB' => [
                'input'    => '1GiB',
                'expected' => ['value' => 1, 'unit' => 'GiB'],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderParse
     *
     * @param mixed $input
     * @param mixed $expected
     */
    public function testParse($input, $expected): void
    {
        $this->assertSame($expected, SizeParser::parse($input));
    }

    public function dataProviderParseException(): array
    {
        return [
            'invalidPattern: input is empty string' => ['input' => ''],
            'invalidPattern: input is invalid'      => ['input' => 'invalid'],
            'invalidPattern: input is -1'           => ['input' => '-1'],
            'invalidPattern: input is 0'            => ['input' => '0'],
            'invalidPattern: input is 1'            => ['input' => '1'],
            'invalidPattern: input is 1.2'          => ['input' => '1.2'],
            'invalidPattern: input is -1GB'         => ['input' => '-1GB'],
            'invalidPattern: input is 1.2GB'        => ['input' => '1.2GB'],
            'invalidPattern: input is 1GB1'         => ['input' => '1GB1'],
            'invalidPattern: input is B'            => ['input' => 'B'],
            'invalidPattern: input is GB'           => ['input' => 'GB'],
        ];
    }

    /**
     * @dataProvider dataProviderParseException
     *
     * @param mixed $input
     */
    public function testParseException($input): void
    {
        $this->expectException(InvalidArgumentException::class);
        SizeParser::parse($input);
    }
}
