<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\DateTime;

use DateTime;
use PHPUnit\Framework\TestCase;
use Selen\DateTime\Util;

/**
 * @coversDefaultClass \mixed\Util
 *
 * @see mixed\Util
 *
 * @internal
 */
class UtilTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderIsFeature(): array
    {
        return [
            'validPattern: 未来の日付' => [
                'expected' => true,
                'input'    => (new DateTime())->modify('+5 minute'),
            ],
            'validPattern: 過去の日付' => [
                'expected' => false,
                'input'    => (new DateTime())->modify('-5 minute'),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderIsFeature
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testIsFeature($expected, $input): void
    {
        $this->assertSame($expected, (new Util($input))->isFeature());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderIsPast(): array
    {
        return [
            'validPattern: 未来の日付' => [
                'expected' => false,
                'input'    => (new DateTime())->modify('+5 minute'),
            ],
            'validPattern: 過去の日付' => [
                'expected' => true,
                'input'    => (new DateTime())->modify('-5 minute'),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderIsPast
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testIsPast($expected, $input): void
    {
        $this->assertSame($expected, (new Util($input))->isPast());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderEq(): array
    {
        return [
            'validPattern: 同じ日付' => [
                'expected' => true,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 異なる日付' => [
                'expected' => false,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-17'),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderEq
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testEq($expected, $input): void
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->eq($dateTime));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderNe(): array
    {
        return [
            'validPattern: 同じ日付' => [
                'expected' => false,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 異なる日付' => [
                'expected' => true,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-17'),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderNe
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testNe($expected, $input): void
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->ne($dateTime));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderGt(): array
    {
        return [
            'validPattern: 境界値（record > dateTime）' => [
                'expected' => true,
                'input'    => [
                    'util'     => new DateTime('2023-4-19'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record >= dateTime）' => [
                'expected' => false,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record <= dateTime）' => [
                'expected' => false,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record < dateTime）' => [
                'expected' => false,
                'input'    => [
                    'util'     => new DateTime('2023-4-17'),
                    'dateTime' => new DateTime('2023-4-19'),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGt
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGt($expected, $input): void
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->gt($dateTime));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderGe(): array
    {
        return [
            'validPattern: 境界値（record > dateTime）' => [
                'expected' => true,
                'input'    => [
                    'util'     => new DateTime('2023-4-19'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record >= dateTime）' => [
                'expected' => true,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record <= dateTime）' => [
                'expected' => true,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record < dateTime）' => [
                'expected' => false,
                'input'    => [
                    'util'     => new DateTime('2023-4-17'),
                    'dateTime' => new DateTime('2023-4-19'),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGe
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGe($expected, $input): void
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->ge($dateTime));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderLe(): array
    {
        return [
            'validPattern: 境界値（record > dateTime）' => [
                'expected' => false,
                'input'    => [
                    'util'     => new DateTime('2023-4-19'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record >= dateTime）' => [
                'expected' => true,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record <= dateTime）' => [
                'expected' => true,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record < dateTime）' => [
                'expected' => true,
                'input'    => [
                    'util'     => new DateTime('2023-4-17'),
                    'dateTime' => new DateTime('2023-4-19'),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderLe
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testLe($expected, $input): void
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->le($dateTime));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderLt(): array
    {
        return [
            'validPattern: 境界値（record > dateTime）' => [
                'expected' => false,
                'input'    => [
                    'util'     => new DateTime('2023-4-19'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record >= dateTime）' => [
                'expected' => false,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record <= dateTime）' => [
                'expected' => false,
                'input'    => [
                    'util'     => new DateTime('2023-4-18'),
                    'dateTime' => new DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record < dateTime）' => [
                'expected' => true,
                'input'    => [
                    'util'     => new DateTime('2023-4-17'),
                    'dateTime' => new DateTime('2023-4-19'),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderLt
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testLt($expected, $input): void
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->lt($dateTime));
    }
}
