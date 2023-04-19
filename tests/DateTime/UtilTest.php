<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen;

use DateTime;
use PHPUnit\Framework\TestCase;
use Selen\DateTime\Util;

/**
 * @coversDefaultClass \mixed\Util
 *
 * @group Selen
 * @group Selen/DateTime/Util
 *
 * @see mixed\Util
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/DateTime/Util
 *
 * @internal
 */
class UtilTest extends TestCase
{
    public function dataProviderIsFeature()
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
    public function testIsFeature($expected, $input)
    {
        $this->assertSame($expected, (new Util($input))->isFeature());
    }

    public function dataProviderIsPast()
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
    public function testIsPast($expected, $input)
    {
        $this->assertSame($expected, (new Util($input))->isPast());
    }

    public function dataProviderEq()
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
    public function testEq($expected, $input)
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->eq($dateTime));
    }

    public function dataProviderNe()
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
    public function testNe($expected, $input)
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->ne($dateTime));
    }

    public function dataProviderGt()
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
    public function testGt($expected, $input)
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->gt($dateTime));
    }

    public function dataProviderGe()
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
    public function testGe($expected, $input)
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->ge($dateTime));
    }

    public function dataProviderLe()
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
    public function testLe($expected, $input)
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->le($dateTime));
    }

    public function dataProviderLt()
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
    public function testLt($expected, $input)
    {
        [
            'util'     => $util,
            'dateTime' => $dateTime,
        ] = $input;

        $this->assertSame($expected, (new Util($util))->lt($dateTime));
    }
}
