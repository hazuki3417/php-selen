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
 * @group Selen
 * @group Selen/DateTime
 *
 * @see \Selen\DateTime
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/DateTime
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

    public function dataProviderIsFeature()
    {
        $featureTimeStamp = (new \DateTime())->modify('+5 minute')->getTimestamp();
        $pastTimeStamp    = (new \DateTime())->modify('-5 minute')->getTimestamp();
        return [
            'validPattern: 未来の日付' => [
                'expected' => true,
                'input'    => DateTime::parseInt($featureTimeStamp),
            ],
            'validPattern: 過去の日付' => [
                'expected' => false,
                'input'    => DateTime::parseInt($pastTimeStamp),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderIsFeature
     *
     * @param mixed $expected
     * @param \Selen\DateTime $input
     */
    public function testIsFeature($expected, $input)
    {
        $this->assertSame($expected, $input->isFeature());
    }

    public function dataProviderIsPast()
    {
        $featureTimeStamp = (new \DateTime())->modify('+5 minute')->getTimestamp();
        $pastTimeStamp    = (new \DateTime())->modify('-5 minute')->getTimestamp();
        return [
            'validPattern: 未来の日付' => [
                'expected' => false,
                'input'    => DateTime::parseInt($featureTimeStamp),
            ],
            'validPattern: 過去の日付' => [
                'expected' => true,
                'input'    => DateTime::parseInt($pastTimeStamp),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderIsPast
     *
     * @param mixed $expected
     * @param \Selen\DateTime $input
     */
    public function testIsPast($expected, $input)
    {
        $this->assertSame($expected, $input->isPast());
    }

    public function dataProviderEq()
    {
        return [
            'validPattern: 同じ日付' => [
                'expected' => true,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new \DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 異なる日付' => [
                'expected' => false,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new \DateTime('2023-4-17'),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderEq
     *
     * @param mixed $expected
     * @param \Selen\DateTime $input
     */
    public function testEq($expected, $input)
    {
        [
            'record'   => $record,
            'dateTime' => $dateTime,
        ] = $input;

        $actual = new DateTime($record);
        $this->assertSame($expected, $actual->eq($dateTime));
    }

    public function dataProviderNe()
    {
        return [
            'validPattern: 同じ日付' => [
                'expected' => false,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new \DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 異なる日付' => [
                'expected' => true,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new \DateTime('2023-4-17'),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderNe
     *
     * @param mixed $expected
     * @param \Selen\DateTime $input
     */
    public function testNe($expected, $input)
    {
        [
            'record'   => $record,
            'dateTime' => $dateTime,
        ] = $input;

        $actual = new DateTime($record);
        $this->assertSame($expected, $actual->ne($dateTime));
    }

    public function dataProviderGt()
    {
        return [
            'validPattern: 境界値（record > dateTime）' => [
                'expected' => true,
                'input'    => [
                    'record'   => new Record(2023, 4, 19),
                    'dateTime' => new \DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record >= dateTime）' => [
                'expected' => false,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new DateTime(new Record(2023, 4, 18)),
                ],
            ],
            'validPattern: 境界値（record <= dateTime）' => [
                'expected' => false,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new \DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record < dateTime）' => [
                'expected' => false,
                'input'    => [
                    'record'   => new Record(2023, 4, 17),
                    'dateTime' => new DateTime(new Record(2023, 4, 19)),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGt
     *
     * @param mixed $expected
     * @param \Selen\DateTime $input
     */
    public function testGt($expected, $input)
    {
        [
            'record'   => $record,
            'dateTime' => $dateTime,
        ] = $input;

        $actual = new DateTime($record);
        $this->assertSame($expected, $actual->gt($dateTime));
    }

    public function dataProviderGe()
    {
        return [
            'validPattern: 境界値（record > dateTime）' => [
                'expected' => true,
                'input'    => [
                    'record'   => new Record(2023, 4, 19),
                    'dateTime' => new \DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record >= dateTime）' => [
                'expected' => true,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new DateTime(new Record(2023, 4, 18)),
                ],
            ],
            'validPattern: 境界値（record <= dateTime）' => [
                'expected' => true,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new \DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record < dateTime）' => [
                'expected' => false,
                'input'    => [
                    'record'   => new Record(2023, 4, 17),
                    'dateTime' => new DateTime(new Record(2023, 4, 19)),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGe
     *
     * @param mixed $expected
     * @param \Selen\DateTime $input
     */
    public function testGe($expected, $input)
    {
        [
            'record'   => $record,
            'dateTime' => $dateTime,
        ] = $input;

        $actual = new DateTime($record);
        $this->assertSame($expected, $actual->ge($dateTime));
    }

    public function dataProviderLe()
    {
        return [
            'validPattern: 境界値（record > dateTime）' => [
                'expected' => false,
                'input'    => [
                    'record'   => new Record(2023, 4, 19),
                    'dateTime' => new \DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record >= dateTime）' => [
                'expected' => true,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new DateTime(new Record(2023, 4, 18)),
                ],
            ],
            'validPattern: 境界値（record <= dateTime）' => [
                'expected' => true,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new \DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record < dateTime）' => [
                'expected' => true,
                'input'    => [
                    'record'   => new Record(2023, 4, 17),
                    'dateTime' => new DateTime(new Record(2023, 4, 19)),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderLe
     *
     * @param mixed $expected
     * @param \Selen\DateTime $input
     */
    public function testLe($expected, $input)
    {
        [
            'record'   => $record,
            'dateTime' => $dateTime,
        ] = $input;

        $actual = new DateTime($record);
        $this->assertSame($expected, $actual->le($dateTime));
    }

    public function dataProviderLt()
    {
        return [
            'validPattern: 境界値（record > dateTime）' => [
                'expected' => false,
                'input'    => [
                    'record'   => new Record(2023, 4, 19),
                    'dateTime' => new \DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record >= dateTime）' => [
                'expected' => false,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new DateTime(new Record(2023, 4, 18)),
                ],
            ],
            'validPattern: 境界値（record <= dateTime）' => [
                'expected' => false,
                'input'    => [
                    'record'   => new Record(2023, 4, 18),
                    'dateTime' => new \DateTime('2023-4-18'),
                ],
            ],
            'validPattern: 境界値（record < dateTime）' => [
                'expected' => true,
                'input'    => [
                    'record'   => new Record(2023, 4, 17),
                    'dateTime' => new DateTime(new Record(2023, 4, 19)),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderLt
     *
     * @param mixed $expected
     * @param \Selen\DateTime $input
     */
    public function testLt($expected, $input)
    {
        [
            'record'   => $record,
            'dateTime' => $dateTime,
        ] = $input;

        $actual = new DateTime($record);
        $this->assertSame($expected, $actual->lt($dateTime));
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
