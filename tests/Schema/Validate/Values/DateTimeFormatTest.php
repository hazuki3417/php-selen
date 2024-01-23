<?php

declare(strict_types=1);

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Values;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\DateTimeFormat;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\DateTimeFormat
 *
 * @see DateTimeFormat
 *
 * @internal
 */
class DateTimeFormatTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(DateTimeFormat::class, new DateTimeFormat('string'));
    }

    public function dataProviderExecute()
    {
        return [
            'validDataType: value is not string type' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of string type.'),
                'input'    => [
                    'format' => 'Y-m-d H:i',
                    'value'  => 1,
                ],
            ],
            'validDataType: date format is Y-m-d' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y-m-d',
                    'value'  => '2019-01-01',
                ],
            ],
            'validDataType: date format is Y-m-d' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y-m-d',
                    'value'  => '2019-12-31',
                ],
            ],
            'validDataType: date format is Y/m/d' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y/m/d',
                    'value'  => '2019/01/01',
                ],
            ],
            'validDataType: date format is Y/m/d' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y/m/d',
                    'value'  => '2019/12/31',
                ],
            ],
            'validDataType: date format is Y m d' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y m d',
                    'value'  => '2019 01 01',
                ],
            ],
            'validDataType: date format is Y m d' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y m d',
                    'value'  => '2019 12 31',
                ],
            ],
            'validDataType: date format is Ymd' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Ymd',
                    'value'  => '20190101',
                ],
            ],
            'validDataType: date format is Ymd' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Ymd',
                    'value'  => '20191231',
                ],
            ],
            'validDataType: date format is YmdHis' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'YmdHis',
                    'value'  => '20190101000000',
                ],
            ],
            'validDataType: date format is YmdHis' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'YmdHis',
                    'value'  => '20191231000000',
                ],
            ],
            'validDataType: date format is H:i' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'H:i',
                    'value'  => '00:00',
                ],
            ],
            'validDataType: date format is Hi' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Hi',
                    'value'  => '0000',
                ],
            ],
            'validDataType: date format is H:i:s' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'H:i:s',
                    'value'  => '00:00:00',
                ],
            ],
            'validDataType: date format is His' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'His',
                    'value'  => '000000',
                ],
            ],
            'validDataType: date format is Y-m-d H:i' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y-m-d H:i',
                    'value'  => '2019-01-01 00:00',
                ],
            ],
            'validDataType: date format is Y-m-d H:i' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y-m-d H:i',
                    'value'  => '2019-12-31 00:00',
                ],
            ],
            'validDataType: date format is Y/m/d H:i:s' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y/m/d H:i:s',
                    'value'  => '2019/01/01 00:00:00',
                ],
            ],
            'validDataType: date format is Y/m/d H:i:s' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y/m/d H:i:s',
                    'value'  => '2019/12/31 00:00:00',
                ],
            ],
            'validDataType: date format is Y m d H i' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y m d H i',
                    'value'  => '2019 01 01 00 00',
                ],
            ],
            'validDataType: date format is Y m d H i' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Y m d H i',
                    'value'  => '2019 12 31 00 00',
                ],
            ],
            'validDataType: date format is Ymd' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Ymd',
                    'value'  => '20190101',
                ],
            ],
            'validDataType: date format is Ymd' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'Ymd',
                    'value'  => '20191231',
                ],
            ],
            'validDataType: date format is YmdHis' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'YmdHis',
                    'value'  => '20190101000000',
                ],
            ],
            'validDataType: date format is YmdHis' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'format' => 'YmdHis',
                    'value'  => '20191231000000',
                ],
            ],
            // ゼロ埋めなし
            'invalidDataType: date format Y-m-d' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d.'),
                'input'    => [
                    'format' => 'Y-m-d',
                    'value'  => '2019-1-1',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format Y-m-d' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d.'),
                'input'    => [
                    'format' => 'Y-m-d',
                    'value'  => '20190101',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format Y-m-d' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d.'),
                'input'    => [
                    'format' => 'Y-m-d',
                    'value'  => '2019/01/01',
                ],
            ],
            // 日付に変換できない文字
            'invalidDataType: date format Y-m-d' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d.'),
                'input'    => [
                    'format' => 'Y-m-d',
                    'value'  => '1234-56-78',
                ],
            ],
            // 存在しない日付
            'invalidDataType: date format Y-m-d' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d.'),
                'input'    => [
                    'format' => 'Y-m-d',
                    'value'  => '2019-01-32',
                ],
            ],
            // うるう年じゃないのに29日
            'invalidDataType: date format Y-m-d' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d.'),
                'input'    => [
                    'format' => 'Y-m-d',
                    'value'  => '2017-02-29',
                ],
            ],
            // 存在しない時間
            'invalidDataType: date format H:i' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format H:i.'),
                'input'    => [
                    'format' => 'H:i',
                    'value'  => '24:00',
                ],
            ],
            // 存在しない時間
            'invalidDataType: date format Hi' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Hi.'),
                'input'    => [
                    'format' => 'Hi',
                    'value'  => '2400',
                ],
            ],
            // 存在しない時間
            'invalidDataType: date format H:i:s' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format H:i:s.'),
                'input'    => [
                    'format' => 'H:i:s',
                    'value'  => '24:00:00',
                ],
            ],
            // 存在しない時間
            'invalidDataType: date format His' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format His.'),
                'input'    => [
                    'format' => 'His',
                    'value'  => '240000',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format H:i' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format H:i.'),
                'input'    => [
                    'format' => 'H:i',
                    'value'  => '0000',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format Hi' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Hi.'),
                'input'    => [
                    'format' => 'Hi',
                    'value'  => '00:00',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format H:i:s' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format H:i:s.'),
                'input'    => [
                    'format' => 'H:i:s',
                    'value'  => '000000',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format His' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format His.'),
                'input'    => [
                    'format' => 'His',
                    'value'  => '240000',
                ],
            ],
            // ゼロ埋めなし
            'invalidDataType: date format Y-m-d H:i' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d H:i.'),
                'input'    => [
                    'format' => 'Y-m-d H:i',
                    'value'  => '2019-1-1 1:1',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format Y-m-d H:i' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d H:i.'),
                'input'    => [
                    'format' => 'Y-m-d H:i',
                    'value'  => '201901010101',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format Y-m-d H:i' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d H:i.'),
                'input'    => [
                    'format' => 'Y-m-d H:i',
                    'value'  => '2019/01/01 01:01',
                ],
            ],
            // 日付に変換できない文字
            'invalidDataType: date format Y-m-d H:i' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d H:i.'),
                'input'    => [
                    'format' => 'Y-m-d H:i',
                    'value'  => '1234-56-78 00:00',
                ],
            ],
            // 時刻に変換できない文字
            'invalidDataType: date format Y-m-d H:i' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d H:i.'),
                'input'    => [
                    'format' => 'Y-m-d H:i',
                    'value'  => '2019-12-31 99:99',
                ],
            ],
            // 存在しない日付
            'invalidDataType: date format Y-m-d H:i' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d H:i.'),
                'input'    => [
                    'format' => 'Y-m-d H:i',
                    'value'  => '2019-01-32 00:00',
                ],
            ],
            // うるう年じゃないのに29日
            'invalidDataType: date format Y-m-d H:i' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value format Y-m-d H:i.'),
                'input'    => [
                    'format' => 'Y-m-d H:i',
                    'value'  => '2017-02-29 00:00',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param ValidateResult $expected
     * @param mixed          $input
     */
    public function testExecute($expected, $input)
    {
        [
            'format' => $format,
            'value'  => $value,
        ] = $input;

        $actual = (new DateTimeFormat($format))
            ->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
    }
}
