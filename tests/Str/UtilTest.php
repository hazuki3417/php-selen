<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Str;

use PHPUnit\Framework\TestCase;
use Selen\Str\Util;
use ValueError;

/**
 * @coversDefaultClass \Selen\Str\Util
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
    public function dataProviderToBoolException(): array
    {
        return [
            'invalidPattern: 001' => [
                'expected' => [
                    'errorClass'   => ValueError::class,
                    'errorMessage' => "Invalid value. Expected value 'true' or 'false'",
                ],
                'input' => '',
            ],
            'invalidPattern: 002' => [
                'expected' => [
                    'errorClass'   => ValueError::class,
                    'errorMessage' => "Invalid value. Expected value 'true' or 'false'",
                ],
                'input' => 'test',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderToBoolException
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToBoolException($expected, $input): void
    {
        [
            'errorClass'   => $errorClass,
            'errorMessage' => $errorMessage,
        ] = $expected;

        $this->expectException($errorClass);
        $this->expectExceptionMessage($errorMessage);

        Util::toBool($input);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderToBool(): array
    {
        return [
            'validPattern: 001' => [
                'expected' => true,
                'input'    => 'true',
            ],
            'validPattern: 002' => [
                'expected' => false,
                'input'    => 'false',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderToBool
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToBool($expected, $input): void
    {
        $this->assertSame($expected, Util::toBool($input));
    }
}
