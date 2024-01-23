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
    public function testConstruct(): void
    {
        $this->assertInstanceOf(DateTimeFormat::class, new DateTimeFormat('string'));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderExecute(): array
    {
        return [
            'validDataType: value is not string type' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of string type.'),
                'input'    => [
                    'args'  => ['Y-m-d H:i', false],
                    'value' => 1,
                ],
            ],
            'validDataType: date format Y-m-d 2019-01-01' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y-m-d', false],
                    'value' => '2019-01-01',
                ],
            ],
            'validDataType: date format Y-m-d 2019-12-31' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y-m-d', false],
                    'value' => '2019-12-31',
                ],
            ],
            'validDataType: date format Y/m/d 2019/01/01' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y/m/d', false],
                    'value' => '2019/01/01',
                ],
            ],
            'validDataType: date format Y/m/d 2019/12/31' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y/m/d', false],
                    'value' => '2019/12/31',
                ],
            ],
            'validDataType: date format Y m d 2019 01 01' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y m d', false],
                    'value' => '2019 01 01',
                ],
            ],
            'validDataType: date format Y m d 2019 12 31' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y m d', false],
                    'value' => '2019 12 31',
                ],
            ],
            'validDataType: date format Ymd 20190101' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Ymd', false],
                    'value' => '20190101',
                ],
            ],
            'validDataType: date format Ymd 20191231' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Ymd', false],
                    'value' => '20191231',
                ],
            ],
            'validDataType: date format YmdHis 20190101000000' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['YmdHis', false],
                    'value' => '20190101000000',
                ],
            ],
            'validDataType: date format YmdHis 20191231000000' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['YmdHis', false],
                    'value' => '20191231000000',
                ],
            ],
            'validDataType: date format H:i 00:00' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['H:i', false],
                    'value' => '00:00',
                ],
            ],
            'validDataType: date format Hi 0000' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Hi', false],
                    'value' => '0000',
                ],
            ],
            'validDataType: date format H:i:s 00:00:00' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['H:i:s', false],
                    'value' => '00:00:00',
                ],
            ],
            'validDataType: date format His 000000' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['His', false],
                    'value' => '000000',
                ],
            ],
            'validDataType: date format Y-m-d H:i 2019-01-01 00:00' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y-m-d H:i', false],
                    'value' => '2019-01-01 00:00',
                ],
            ],
            'validDataType: date format Y-m-d H:i 2019-12-31 00:00' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y-m-d H:i', false],
                    'value' => '2019-12-31 00:00',
                ],
            ],
            'validDataType: date format Y/m/d H:i:s 2019/01/01 00:00:00' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y/m/d H:i:s', false],
                    'value' => '2019/01/01 00:00:00',
                ],
            ],
            'validDataType: date format Y/m/d H:i:s 2019/12/31 00:00:00' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y/m/d H:i:s', false],
                    'value' => '2019/12/31 00:00:00',
                ],
            ],
            'validDataType: date format Y m d H i 2019 01 01 00 00' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y m d H i', false],
                    'value' => '2019 01 01 00 00',
                ],
            ],
            'validDataType: date format Y m d H i 2019 12 31 00 00' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y m d H i', false],
                    'value' => '2019 12 31 00 00',
                ],
            ],
            // ゼロ埋めなし
            'invalidDataType: date format Y-m-d 2019-1-1' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d.'),
                'input'    => [
                    'args'  => ['Y-m-d', false],
                    'value' => '2019-1-1',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format Y-m-d 20190101' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d.'),
                'input'    => [
                    'args'  => ['Y-m-d', false],
                    'value' => '20190101',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format Y-m-d 2019/01/01' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d.'),
                'input'    => [
                    'args'  => ['Y-m-d', false],
                    'value' => '2019/01/01',
                ],
            ],
            // 日付に変換できない文字
            'invalidDataType: date format Y-m-d 1234-56-78' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d.'),
                'input'    => [
                    'args'  => ['Y-m-d', false],
                    'value' => '1234-56-78',
                ],
            ],
            // 存在しない日付
            'invalidDataType: date format Y-m-d 2019-01-32' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d.'),
                'input'    => [
                    'args'  => ['Y-m-d', false],
                    'value' => '2019-01-32',
                ],
            ],
            // うるう年じゃないのに29日
            'invalidDataType: date format Y-m-d 2017-02-29' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d.'),
                'input'    => [
                    'args'  => ['Y-m-d', false],
                    'value' => '2017-02-29',
                ],
            ],
            // 存在しない時間
            'invalidDataType: date format H:i 24:00' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format H:i.'),
                'input'    => [
                    'args'  => ['H:i', false],
                    'value' => '24:00',
                ],
            ],
            // 存在しない時間
            'invalidDataType: date format Hi 2400' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Hi.'),
                'input'    => [
                    'args'  => ['Hi', false],
                    'value' => '2400',
                ],
            ],
            // 存在しない時間
            'invalidDataType: date format H:i:s 24:00:00' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format H:i:s.'),
                'input'    => [
                    'args'  => ['H:i:s', false],
                    'value' => '24:00:00',
                ],
            ],
            // 存在しない時間
            'invalidDataType: date format His 240000' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format His.'),
                'input'    => [
                    'args'  => ['His', false],
                    'value' => '240000',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format H:i 0000' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format H:i.'),
                'input'    => [
                    'args'  => ['H:i', false],
                    'value' => '0000',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format Hi 00:00' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Hi.'),
                'input'    => [
                    'args'  => ['Hi', false],
                    'value' => '00:00',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format H:i:s 000000' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format H:i:s.'),
                'input'    => [
                    'args'  => ['H:i:s', false],
                    'value' => '000000',
                ],
            ],
            // ゼロ埋めなし
            'invalidDataType: date format Y-m-d H:i 2019-1-1 1:1' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d H:i.'),
                'input'    => [
                    'args'  => ['Y-m-d H:i', false],
                    'value' => '2019-1-1 1:1',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format Y-m-d H:i 201901010101' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d H:i.'),
                'input'    => [
                    'args'  => ['Y-m-d H:i', false],
                    'value' => '201901010101',
                ],
            ],
            // フォーマット違い
            'invalidDataType: date format Y-m-d H:i 2019/01/01 01:01' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d H:i.'),
                'input'    => [
                    'args'  => ['Y-m-d H:i', false],
                    'value' => '2019/01/01 01:01',
                ],
            ],
            // 日付に変換できない文字
            'invalidDataType: date format Y-m-d H:i 1234-56-78 00:00' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d H:i.'),
                'input'    => [
                    'args'  => ['Y-m-d H:i', false],
                    'value' => '1234-56-78 00:00',
                ],
            ],
            // 時刻に変換できない文字
            'invalidDataType: date format Y-m-d H:i 2019-12-31 99:99' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d H:i.'),
                'input'    => [
                    'args'  => ['Y-m-d H:i', false],
                    'value' => '2019-12-31 99:99',
                ],
            ],
            // 存在しない日付
            'invalidDataType: date format Y-m-d H:i 2019-01-32 00:00' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d H:i.'),
                'input'    => [
                    'args'  => ['Y-m-d H:i', false],
                    'value' => '2019-01-32 00:00',
                ],
            ],
            // うるう年じゃないのに29日
            'invalidDataType: date format Y-m-d H:i 2017-02-29 00:00' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d H:i.'),
                'input'    => [
                    'args'  => ['Y-m-d H:i', false],
                    'value' => '2017-02-29 00:00',
                ],
            ],
            //空許容パターン 異常(1) 空許容する & 文字以外の値を設定 -> Skip validationが動作すること
            'validDataType: allow empty (value is not string type)' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of string type.'),
                'input'    => [
                    'args'  => ['Y-m-d H:i', true],
                    'value' => 1,
                ],
            ],
            //空許容パターン 正常(1) 空許容する & Y-m-dフォーマット 値あり
            'validDataType: allow empty( date format Y-m-d 2019-01-01)' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y-m-d', true],
                    'value' => '2019-01-01',
                ],
            ],
            //空許容パターン 正常(2) 空許容する & Y-m-d H:i:s 値あり
            'validDataType: allow empty(date format Y-m-d H:i:s 2019-01-01 00:00:00)' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y-m-d H:i:s', true],
                    'value' => '2019-01-01 00:00:00',
                ],
            ],
            //空許容パターン 正常(3) 空許容する & Y-m-dフォーマット 値なし
            'validDataType: allow empty(value empty date format Y-m-d)' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y-m-d', true],
                    'value' => '',
                ],
            ],
            //空許容パターン 正常(2) 空許容する & Y-m-d H:i:s 値なし
            'validDataType: allow empty(value empty date format Y-m-d H:i:s)' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => ['Y-m-d H:i:s', true],
                    'value' => '',
                ],
            ],
            //空許容パターン 異常(2) 空許容しない & Y-m-dフォーマット 値なし
            'validDataType: allow not empty(value empty)' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d.'),
                'input'    => [
                    'args'  => ['Y-m-d', false],
                    'value' => '',
                ],
            ],
            //空許容パターン 異常(3) 空許容する & フォーマット違い
            'invalidDataType: allow empty(date format Y-m-d 2019/01/01)' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d.'),
                'input'    => [
                    'args'  => ['Y-m-d', true],
                    'value' => '2019/01/01',
                ],
            ],
            // 空許容パターン 異常(4) 日付に変換できない文字
            'invalidDataType: allow empty(date format Y-m-d 1234-56-78)' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Expected value format Y-m-d.'),
                'input'    => [
                    'args'  => ['Y-m-d', true],
                    'value' => '1234-56-78',
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
    public function testExecute($expected, $input): void
    {
        [
            'args'  => $args,
            'value' => $value,
        ] = $input;

        $actual = (new DateTimeFormat(...$args))
            ->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
    }
}
