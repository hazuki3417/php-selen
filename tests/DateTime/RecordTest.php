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
use Selen\DateTime\Record;
use ValueError;

/**
 * @coversDefaultClass \Selen\DateTime\Record
 *
 * @group Selen
 * @group Selen/DateTime/Record
 *
 * @see \Selen\DateTime\Record
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/DateTime/Record
 *
 * @internal
 */
class RecordTest extends TestCase
{
    public function dataProviderConstructException()
    {
        return [
            'invalidPattern: year === 0' => [
                'expected' => [
                    'exceptionClass'   => ValueError::class,
                    'exceptionMessage' => 'Invalid value. Please specify a value of 1 or more for $year.',
                ],
                'input' => [
                    'year'   => 0,
                    'month'  => 1,
                    'day'    => 1,
                    'hour'   => 0,
                    'minute' => 0,
                    'second' => 0,
                ],
            ],
            'invalidPattern: month === 0' => [
                'expected' => [
                    'exceptionClass'   => ValueError::class,
                    'exceptionMessage' => 'Invalid value. Please specify a value of 1 or more for $month.',
                ],
                'input' => [
                    'year'   => 1,
                    'month'  => 0,
                    'day'    => 1,
                    'hour'   => 0,
                    'minute' => 0,
                    'second' => 0,
                ],
            ],
            'invalidPattern: day === 0' => [
                'expected' => [
                    'exceptionClass'   => ValueError::class,
                    'exceptionMessage' => 'Invalid value. Please specify a value of 1 or more for $day.',
                ],
                'input' => [
                    'year'   => 1,
                    'month'  => 1,
                    'day'    => 0,
                    'hour'   => 0,
                    'minute' => 0,
                    'second' => 0,
                ],
            ],
            'invalidPattern: hour === -1' => [
                'expected' => [
                    'exceptionClass'   => ValueError::class,
                    'exceptionMessage' => 'Invalid value. Please specify a value of 0 or more for $hour.',
                ],
                'input' => [
                    'year'   => 1,
                    'month'  => 1,
                    'day'    => 1,
                    'hour'   => -1,
                    'minute' => 0,
                    'second' => 0,
                ],
            ],
            'invalidPattern: minute === -1' => [
                'expected' => [
                    'exceptionClass'   => ValueError::class,
                    'exceptionMessage' => 'Invalid value. Please specify a value of 0 or more for $minute.',
                ],
                'input' => [
                    'year'   => 1,
                    'month'  => 1,
                    'day'    => 1,
                    'hour'   => 0,
                    'minute' => -1,
                    'second' => 0,
                ],
            ],
            'invalidPattern: second === -1' => [
                'expected' => [
                    'exceptionClass'   => ValueError::class,
                    'exceptionMessage' => 'Invalid value. Please specify a value of 0 or more for $second.',
                ],
                'input' => [
                    'year'   => 1,
                    'month'  => 1,
                    'day'    => 1,
                    'hour'   => 0,
                    'minute' => 0,
                    'second' => -1,
                ],
            ],
            'invalidPattern: not a leap year' => [
                'expected' => [
                    'exceptionClass'   => ValueError::class,
                    'exceptionMessage' => 'Invalid Gregorian calendar.',
                ],
                'input' => [
                    'year'   => 2023,
                    'month'  => 2,
                    'day'    => 29,
                    'hour'   => 0,
                    'minute' => 0,
                    'second' => 0,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderConstructException
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testConstructException($expected, $input)
    {
        [
            'exceptionClass'   => $exceptionClass,
            'exceptionMessage' => $exceptionMessage,
        ] = $expected;

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);
        new Record(...$input);
    }

    public function dataProviderConstruct()
    {
        return [
            'validPattern: 引数なし' => [
                'expected' => Record::class,
                'input'    => [],
            ],
            'validPattern: 境界値テスト（year）' => [
                'expected' => Record::class,
                'input'    => [
                    'year'   => 1,
                    'month'  => 4,
                    'day'    => 18,
                    'hour'   => 12,
                    'minute' => 30,
                    'second' => 30,
                ],
            ],
            'validPattern: 境界値テスト（month）' => [
                'expected' => Record::class,
                'input'    => [
                    'year'   => 2023,
                    'month'  => 1,
                    'day'    => 18,
                    'hour'   => 12,
                    'minute' => 30,
                    'second' => 30,
                ],
            ],
            'validPattern: 境界値テスト（day）' => [
                'expected' => Record::class,
                'input'    => [
                    'year'   => 2023,
                    'month'  => 4,
                    'day'    => 1,
                    'hour'   => 12,
                    'minute' => 30,
                    'second' => 30,
                ],
            ],
            'validPattern: 境界値テスト（hour）' => [
                'expected' => Record::class,
                'input'    => [
                    'year'   => 2023,
                    'month'  => 4,
                    'day'    => 18,
                    'hour'   => 0,
                    'minute' => 30,
                    'second' => 30,
                ],
            ],
            'validPattern: 境界値テスト（minute）' => [
                'expected' => Record::class,
                'input'    => [
                    'year'   => 2023,
                    'month'  => 4,
                    'day'    => 18,
                    'hour'   => 12,
                    'minute' => 0,
                    'second' => 30,
                ],
            ],
            'validPattern: 境界値テスト（second）' => [
                'expected' => Record::class,
                'input'    => [
                    'year'   => 2023,
                    'month'  => 4,
                    'day'    => 18,
                    'hour'   => 12,
                    'minute' => 30,
                    'second' => 0,
                ],
            ],
            'validPattern: うるう年の日付確認（2020）' => [
                'expected' => Record::class,
                'input'    => [
                    'year'   => 2020,
                    'month'  => 2,
                    'day'    => 29,
                    'hour'   => 0,
                    'minute' => 0,
                    'second' => 0,
                ],
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
        $this->assertInstanceOf($expected, new Record(...$input));
    }

    public function dataProviderClassProperty()
    {
        $nowDateTimeInstance = new DateTime();
        $nowParseFormat      = 'Y-m-d H:i:s';
        $nowDateTime         = $nowDateTimeInstance->format($nowParseFormat);
        $nowParseDateTimeArr = date_parse_from_format($nowParseFormat, $nowDateTime);

        return [
            'validPattern: 初期値の確認' => [
                'expected' => [
                    'year'   => 1,
                    'month'  => 1,
                    'day'    => 1,
                    'hour'   => 0,
                    'minute' => 0,
                    'second' => 0,
                ],
                'input' => [
                ],
            ],            'validPattern: コンストラクタ引数とプロパティの値が同じ' => [
                'expected' => [
                    'year'   => $nowParseDateTimeArr['year'],
                    'month'  => $nowParseDateTimeArr['month'],
                    'day'    => $nowParseDateTimeArr['day'],
                    'hour'   => $nowParseDateTimeArr['hour'],
                    'minute' => $nowParseDateTimeArr['minute'],
                    'second' => $nowParseDateTimeArr['second'],
                ],
                'input' => [
                    'year'   => $nowParseDateTimeArr['year'],
                    'month'  => $nowParseDateTimeArr['month'],
                    'day'    => $nowParseDateTimeArr['day'],
                    'hour'   => $nowParseDateTimeArr['hour'],
                    'minute' => $nowParseDateTimeArr['minute'],
                    'second' => $nowParseDateTimeArr['second'],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderClassProperty
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testClassProperty($expected, $input)
    {
        [
            'year'   => $year,
            'month'  => $month,
            'day'    => $day,
            'hour'   => $hour,
            'minute' => $minute,
            'second' => $second,
        ] = $expected;

        $record = new Record(...$input);

        $this->assertSame($year, $record->year);
        $this->assertSame($month, $record->month);
        $this->assertSame($day, $record->day);
        $this->assertSame($hour, $record->hour);
        $this->assertSame($minute, $record->minute);
        $this->assertSame($second, $record->second);
    }

    public function dataProviderParseStrException()
    {
        return [
            'invalidPattern: フォーマット文字列が空' => [
                'expected' => [
                    'exceptionClass'   => ValueError::class,
                    'exceptionMessage' => 'Invalid value. Please specify format string.',
                ],
                'input' => [
                    'parseFormat' => '',
                    'dateTime'    => '2001-02-29 00:00:00',
                ],
            ],
            'invalidPattern: 日付文字列が空' => [
                'expected' => [
                    'exceptionClass'   => ValueError::class,
                    'exceptionMessage' => 'Invalid value. Please specify a date string.',
                ],
                'input' => [
                    'parseFormat' => 'Y-m-d',
                    'dateTime'    => '',
                ],
            ],
            'invalidPattern: パースに失敗' => [
                'expected' => [
                    'exceptionClass'   => ValueError::class,
                    'exceptionMessage' => 'Failed to parse. Invalid date format or date string.',
                ],
                'input' => [
                    'parseFormat' => 'Y-m-d',
                    'dateTime'    => '2001-02-29 00:00:00',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderParseStrException
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testParseStrException($expected, $input)
    {
        [
            'exceptionClass'   => $exceptionClass,
            'exceptionMessage' => $exceptionMessage,
        ] = $expected;

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);
        Record::parseStr(...$input);
    }

    public function dataProviderParseStr()
    {
        return [
            'invalidPattern: 有効な日時' => [
                'expected' => Record::class,
                'input'    => [
                    'parseFormat' => 'Y-m-d H:i:s',
                    'dateTime'    => '2023-02-28 12:00:00',
                ],
            ],
            'invalidPattern: 有効なうるう年' => [
                'expected' => Record::class,
                'input'    => [
                    'parseFormat' => 'Y-m-d',
                    'dateTime'    => '2024-02-29',
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
        $this->assertInstanceOf($expected, Record::parseStr(...$input));
    }

    public function dataProviderToDateTime()
    {
        return [
            'validPattern: 001' => [
                'expected' => (new DateTime())->setDate(2023, 4, 18)->setTime(12, 30, 30),
                'input'    => [
                    'year'   => 2023,
                    'month'  => 4,
                    'day'    => 18,
                    'hour'   => 12,
                    'minute' => 30,
                    'second' => 30,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderToDateTime
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToDateTime($expected, $input)
    {
        $format = 'Y-m-d H:i:s';
        $actual = (new Record(...$input))->toDateTime();

        $this->assertInstanceOf(DateTime::class, $actual);
        $this->assertSame(
            $expected->format($format),
            $actual->format($format)
        );
    }
}
