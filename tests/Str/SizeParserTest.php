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
 * @see SizeParser
 *
 * @internal
 */
class SizeParserTest extends TestCase
{
    public function dataProviderToByte(): array
    {
        return [
            'testPattern: input is 0byte' => [
                'expected' => 0,
                'input'    => '0byte',
            ],
            'testPattern: input is 1kB' => [
                'expected' => pow(1000, 1),
                'input'    => '1kB',
            ],
            'testPattern: input is 3kB' => [
                'expected' => 3 * pow(1000, 1),
                'input'    => '3kB',
            ],
            'testPattern: input is 1KiB' => [
                'expected' => pow(1024, 1),
                'input'    => '1KiB',
            ],
            'testPattern: input is 3KiB' => [
                'expected' => 3 * pow(1024, 1),
                'input'    => '3KiB',
            ],
            'testPattern: input is 1MB' => [
                'expected' => pow(1000, 2),
                'input'    => '1MB',
            ],
            'testPattern: input is 3MB' => [
                'expected' => 3 * pow(1000, 2),
                'input'    => '3MB',
            ],
            'testPattern: input is 1MiB' => [
                'expected' => pow(1024, 2),
                'input'    => '1MiB',
            ],
            'testPattern: input is 3MiB' => [
                'expected' => 3 * pow(1024, 2),
                'input'    => '3MiB',
            ],
            'testPattern: input is 1GB' => [
                'expected' => pow(1000, 3),
                'input'    => '1GB',
            ],
            'testPattern: input is 3GB' => [
                'expected' => 3 * pow(1000, 3),
                'input'    => '3GB',
            ],
            'testPattern: input is 1GiB' => [
                'expected' => pow(1024, 3),
                'input'    => '1GiB',
            ],
            'testPattern: input is 3GiB' => [
                'expected' => 3 * pow(1024, 3),
                'input'    => '3GiB',
            ],
            'testPattern: input is 1TB' => [
                'expected' => pow(1000, 4),
                'input'    => '1TB',
            ],
            'testPattern: input is 3TB' => [
                'expected' => 3 * pow(1000, 4),
                'input'    => '3TB',
            ],
            'testPattern: input is 1TiB' => [
                'expected' => pow(1024, 4),
                'input'    => '1TiB',
            ],
            'testPattern: input is 3TiB' => [
                'expected' => 3 * pow(1024, 4),
                'input'    => '3TiB',
            ],
            // これより先の値変換は利用想定が少ないのでテストは軽めに実施
            'testPattern: input is 1PB' => [
                'expected' => pow(1000, 5),
                'input'    => '1PB',
            ],
            'testPattern: input is 1EB' => [
                'expected' => pow(1000, 6),
                'input'    => '1EB',
            ],
            'testPattern: input is 1ZB' => [
                'expected' => pow(1000, 7),
                'input'    => '1ZB',
            ],
            'testPattern: input is 1YB' => [
                'expected' => pow(1000, 8),
                'input'    => '1YB',
            ],
            'testPattern: input is 1RB' => [
                'expected' => pow(1000, 9),
                'input'    => '1RB',
            ],
            'testPattern: input is 1QB' => [
                'expected' => pow(1000, 10),
                'input'    => '1QB',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderToByte
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToByte($expected, $input): void
    {
        $this->assertSame($expected, SizeParser::toByte($input));
    }

    public function dataProviderParse(): array
    {
        return [
            'testPattern: input is 0byte' => [
                'expected' => ['value' => 0, 'unit' => 'byte'],
                'input'    => '0byte',
            ],
            'testPattern: input is 1024B' => [
                'expected' => ['value' => 1024, 'unit' => 'byte'],
                'input'    => '1024byte',
            ],
            'testPattern: input is 1MB' => [
                'expected' => ['value' => 1, 'unit' => 'MB'],
                'input'    => '1MB',
            ],
            'testPattern: input is 1MiB' => [
                'expected' => ['value' => 1, 'unit' => 'MiB'],
                'input'    => '1MiB',
            ],
            'testPattern: input is 1GB' => [
                'expected' => ['value' => 1, 'unit' => 'GB'],
                'input'    => '1GB',
            ],
            'testPattern: input is 1GiB' => [
                'expected' => ['value' => 1, 'unit' => 'GiB'],
                'input'    => '1GiB',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderParse
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testParse($expected, $input): void
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

    public function dataProviderValidParse(): array
    {
        return [
            // 組み合わせテスト
            'validPattern: 1byte' => [
                'expected' => true,
                'input'    => '1byte',
            ],
            'validPattern: 1kB' => [
                'expected' => true,
                'input'    => '1kB',
            ],
            'validPattern: 1MB' => [
                'expected' => true,
                'input'    => '1MB',
            ],
            'validPattern: 1GB' => [
                'expected' => true,
                'input'    => '1GB',
            ],
            'validPattern: 1TB' => [
                'expected' => true,
                'input'    => '1TB',
            ],
            'validPattern: 1PB' => [
                'expected' => true,
                'input'    => '1PB',
            ],
            'validPattern: 1EB' => [
                'expected' => true,
                'input'    => '1EB',
            ],
            'validPattern: 1ZB' => [
                'expected' => true,
                'input'    => '1ZB',
            ],
            'validPattern: 1YB' => [
                'expected' => true,
                'input'    => '1YB',
            ],
            'validPattern: 1RB' => [
                'expected' => true,
                'input'    => '1RB',
            ],
            'validPattern: 1QB' => [
                'expected' => true,
                'input'    => '1QB',
            ],
            'validPattern: 1KiB' => [
                'expected' => true,
                'input'    => '1KiB',
            ],
            'validPattern: 1MiB' => [
                'expected' => true,
                'input'    => '1MiB',
            ],
            'validPattern: 1GiB' => [
                'expected' => true,
                'input'    => '1GiB',
            ],
            'validPattern: 1TiB' => [
                'expected' => true,
                'input'    => '1TiB',
            ],
            'validPattern: 1PiB' => [
                'expected' => true,
                'input'    => '1PiB',
            ],
            'validPattern: 1EiB' => [
                'expected' => true,
                'input'    => '1EiB',
            ],
            'validPattern: 1ZiB' => [
                'expected' => true,
                'input'    => '1ZiB',
            ],
            'validPattern: 1YiB' => [
                'expected' => true,
                'input'    => '1YiB',
            ],
            'validPattern: 1RiB' => [
                'expected' => true,
                'input'    => '1RiB',
            ],
            'validPattern: 1QiB' => [
                'expected' => true,
                'input'    => '1QiB',
            ],
            // 対応していないデータ量フォーマット
            'validPattern: str is empty' => [
                'expected' => false,
                'input'    => '',
            ],
            'validPattern: 1.0KiB' => [
                'expected' => false,
                'input'    => '1.0KiB',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderValidParse
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testValidParse($expected, $input): void
    {
        $this->assertSame($expected, SizeParser::validParse($input));
    }

    public function testThrowParseException()
    {
        $this->expectException(InvalidArgumentException::class);
        SizeParser::throwParseException();
    }
}
