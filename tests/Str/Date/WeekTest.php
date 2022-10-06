<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Str\Date;

use PHPUnit\Framework\TestCase;
use Selen\Str\Date\Week;

/**
 * @coversDefaultClass \Selen\Str\Week
 *
 * @group Selen/Str
 * @group Selen/Str/Week
 *
 * @see \Selen\Str\Week
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Str/Week
 *
 * @internal
 */
class WeekTest extends TestCase
{
    public function dataProviderCheckWeekId()
    {
        return [
            'pattern001' => ['expected' => false, 'input' => -1],
            'pattern002' => ['expected' => true,  'input' => 0],
            'pattern003' => ['expected' => true,  'input' => 1],
            'pattern004' => ['expected' => true,  'input' => 2],
            'pattern005' => ['expected' => true,  'input' => 3],
            'pattern006' => ['expected' => true,  'input' => 4],
            'pattern007' => ['expected' => true,  'input' => 5],
            'pattern008' => ['expected' => true,  'input' => 6],
            'pattern009' => ['expected' => false, 'input' => 7],
        ];
    }

    /**
     * @dataProvider dataProviderCheckWeekId
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testCheckWeekId($expected, $input)
    {
        $this->assertSame($expected, Week::checkWeekId($input));
    }

    public function dataProviderEnWeekStrToWeekId()
    {
        return [
            'pattern001' => ['expected' => 0,  'input' => 'Sunday'],
            'pattern002' => ['expected' => 1,  'input' => 'Monday'],
            'pattern003' => ['expected' => 2,  'input' => 'Tuesday'],
            'pattern004' => ['expected' => 3,  'input' => 'Wednesday'],
            'pattern005' => ['expected' => 4,  'input' => 'Thursday'],
            'pattern006' => ['expected' => 5,  'input' => 'Friday'],
            'pattern007' => ['expected' => 6,  'input' => 'Saturday'],
            'pattern008' => ['expected' => 0,  'input' => 'Sun'],
            'pattern009' => ['expected' => 1,  'input' => 'Mon'],
            'pattern010' => ['expected' => 2,  'input' => 'Tue'],
            'pattern011' => ['expected' => 3,  'input' => 'Wed'],
            'pattern012' => ['expected' => 4,  'input' => 'Thu'],
            'pattern013' => ['expected' => 5,  'input' => 'Fri'],
            'pattern014' => ['expected' => 6,  'input' => 'Sat'],
            'pattern015' => ['expected' => -1, 'input' => 'a'],
        ];
    }

    /**
     * @dataProvider dataProviderEnWeekStrToWeekId
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testEnWeekStrToWeekId($expected, $input)
    {
        $this->assertSame($expected, Week::enWeekStrToWeekId($input));
    }

    public function dataProviderJpWeekStrToWeekId()
    {
        return [
            'pattern001' => ['expected' => 0,  'input' => '日曜日'],
            'pattern002' => ['expected' => 1,  'input' => '月曜日'],
            'pattern003' => ['expected' => 2,  'input' => '火曜日'],
            'pattern004' => ['expected' => 3,  'input' => '水曜日'],
            'pattern005' => ['expected' => 4,  'input' => '木曜日'],
            'pattern006' => ['expected' => 5,  'input' => '金曜日'],
            'pattern007' => ['expected' => 6,  'input' => '土曜日'],
            'pattern008' => ['expected' => 0,  'input' => '日'],
            'pattern009' => ['expected' => 1,  'input' => '月'],
            'pattern010' => ['expected' => 2,  'input' => '火'],
            'pattern011' => ['expected' => 3,  'input' => '水'],
            'pattern012' => ['expected' => 4,  'input' => '木'],
            'pattern013' => ['expected' => 5,  'input' => '金'],
            'pattern014' => ['expected' => 6,  'input' => '土'],
            'pattern015' => ['expected' => -1, 'input' => '曜日'],
        ];
    }

    /**
     * @dataProvider dataProviderJpWeekStrToWeekId
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testJpWeekStrToWeekId($expected, $input)
    {
        $this->assertSame($expected, Week::jpWeekStrToWeekId($input));
    }

    public function dataProviderToJp()
    {
        return [
            'pattern001' => ['expected' => '日曜日', 'input' => ['week' => 'Sunday',    'format' => 'l']],
            'pattern002' => ['expected' => '月曜日', 'input' => ['week' => 'Monday',    'format' => 'l']],
            'pattern003' => ['expected' => '火曜日', 'input' => ['week' => 'Tuesday',   'format' => 'l']],
            'pattern004' => ['expected' => '水曜日', 'input' => ['week' => 'Wednesday', 'format' => 'l']],
            'pattern005' => ['expected' => '木曜日', 'input' => ['week' => 'Thursday',  'format' => 'l']],
            'pattern006' => ['expected' => '金曜日', 'input' => ['week' => 'Friday',    'format' => 'l']],
            'pattern007' => ['expected' => '土曜日', 'input' => ['week' => 'Saturday',  'format' => 'l']],
            'pattern008' => ['expected' => '日曜日', 'input' => ['week' => 'Sun',       'format' => 'l']],
            'pattern009' => ['expected' => '月曜日', 'input' => ['week' => 'Mon',       'format' => 'l']],
            'pattern010' => ['expected' => '火曜日', 'input' => ['week' => 'Tue',       'format' => 'l']],
            'pattern011' => ['expected' => '水曜日', 'input' => ['week' => 'Wed',       'format' => 'l']],
            'pattern012' => ['expected' => '木曜日', 'input' => ['week' => 'Thu',       'format' => 'l']],
            'pattern013' => ['expected' => '金曜日', 'input' => ['week' => 'Fri',       'format' => 'l']],
            'pattern014' => ['expected' => '土曜日', 'input' => ['week' => 'Sat',       'format' => 'l']],
            'pattern015' => ['expected' => '日曜日', 'input' => ['week' => 0,           'format' => 'l']],
            'pattern016' => ['expected' => '月曜日', 'input' => ['week' => 1,           'format' => 'l']],
            'pattern017' => ['expected' => '火曜日', 'input' => ['week' => 2,           'format' => 'l']],
            'pattern018' => ['expected' => '水曜日', 'input' => ['week' => 3,           'format' => 'l']],
            'pattern019' => ['expected' => '木曜日', 'input' => ['week' => 4,           'format' => 'l']],
            'pattern020' => ['expected' => '金曜日', 'input' => ['week' => 5,           'format' => 'l']],
            'pattern021' => ['expected' => '土曜日', 'input' => ['week' => 6,           'format' => 'l']],

            'pattern022' => ['expected' => '日', 'input' => ['week' => 'Sunday',    'format' => 'D']],
            'pattern023' => ['expected' => '月', 'input' => ['week' => 'Monday',    'format' => 'D']],
            'pattern024' => ['expected' => '火', 'input' => ['week' => 'Tuesday',   'format' => 'D']],
            'pattern025' => ['expected' => '水', 'input' => ['week' => 'Wednesday', 'format' => 'D']],
            'pattern026' => ['expected' => '木', 'input' => ['week' => 'Thursday',  'format' => 'D']],
            'pattern027' => ['expected' => '金', 'input' => ['week' => 'Friday',    'format' => 'D']],
            'pattern028' => ['expected' => '土', 'input' => ['week' => 'Saturday',  'format' => 'D']],
            'pattern029' => ['expected' => '日', 'input' => ['week' => 'Sun',       'format' => 'D']],
            'pattern030' => ['expected' => '月', 'input' => ['week' => 'Mon',       'format' => 'D']],
            'pattern031' => ['expected' => '火', 'input' => ['week' => 'Tue',       'format' => 'D']],
            'pattern032' => ['expected' => '水', 'input' => ['week' => 'Wed',       'format' => 'D']],
            'pattern033' => ['expected' => '木', 'input' => ['week' => 'Thu',       'format' => 'D']],
            'pattern034' => ['expected' => '金', 'input' => ['week' => 'Fri',       'format' => 'D']],
            'pattern035' => ['expected' => '土', 'input' => ['week' => 'Sat',       'format' => 'D']],
            'pattern036' => ['expected' => '日', 'input' => ['week' => 0,           'format' => 'D']],
            'pattern037' => ['expected' => '月', 'input' => ['week' => 1,           'format' => 'D']],
            'pattern038' => ['expected' => '火', 'input' => ['week' => 2,           'format' => 'D']],
            'pattern039' => ['expected' => '水', 'input' => ['week' => 3,           'format' => 'D']],
            'pattern040' => ['expected' => '木', 'input' => ['week' => 4,           'format' => 'D']],
            'pattern041' => ['expected' => '金', 'input' => ['week' => 5,           'format' => 'D']],
            'pattern042' => ['expected' => '土', 'input' => ['week' => 6,           'format' => 'D']],
        ];
    }

    /**
     * @dataProvider dataProviderToJp
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToJp($expected, $input)
    {
        $this->assertSame(
            $expected,
            Week::toJp($input['week'], $input['format'])
        );
    }

    /**
     * 許容していないデータ型を指定.
     */
    public function testToJpException1()
    {
        $this->expectException(\InvalidArgumentException::class);
        Week::toJp(true, 'D');
    }

    /**
     * 許容していない値を指定（$week）.
     */
    public function testToJpException2()
    {
        $this->expectException(\InvalidArgumentException::class);
        Week::toJp(-1, 'D');
    }

    /**
     * 許容していない値を指定（$week）.
     */
    public function testToJpException3()
    {
        $this->expectException(\InvalidArgumentException::class);
        Week::toJp('a', 'D');
    }

    /**
     * 許容していない値を指定（$format）.
     */
    public function testToJpException4()
    {
        $this->expectException(\InvalidArgumentException::class);
        Week::toJp(0, 'a');
    }

    public function dataProviderToEn()
    {
        return [
            'pattern001' => ['expected' => 'Sunday',    'input' => ['week' => '日曜日', 'format' => 'l']],
            'pattern002' => ['expected' => 'Monday',    'input' => ['week' => '月曜日', 'format' => 'l']],
            'pattern003' => ['expected' => 'Tuesday',   'input' => ['week' => '火曜日', 'format' => 'l']],
            'pattern004' => ['expected' => 'Wednesday', 'input' => ['week' => '水曜日', 'format' => 'l']],
            'pattern005' => ['expected' => 'Thursday',  'input' => ['week' => '木曜日', 'format' => 'l']],
            'pattern006' => ['expected' => 'Friday',    'input' => ['week' => '金曜日', 'format' => 'l']],
            'pattern007' => ['expected' => 'Saturday',  'input' => ['week' => '土曜日', 'format' => 'l']],
            'pattern008' => ['expected' => 'Sunday',    'input' => ['week' => '日', 'format' => 'l']],
            'pattern009' => ['expected' => 'Monday',    'input' => ['week' => '月', 'format' => 'l']],
            'pattern010' => ['expected' => 'Tuesday',   'input' => ['week' => '火', 'format' => 'l']],
            'pattern011' => ['expected' => 'Wednesday', 'input' => ['week' => '水', 'format' => 'l']],
            'pattern012' => ['expected' => 'Thursday',  'input' => ['week' => '木', 'format' => 'l']],
            'pattern013' => ['expected' => 'Friday',    'input' => ['week' => '金', 'format' => 'l']],
            'pattern014' => ['expected' => 'Saturday',  'input' => ['week' => '土', 'format' => 'l']],
            'pattern015' => ['expected' => 'Sunday',    'input' => ['week' => 0, 'format' => 'l']],
            'pattern016' => ['expected' => 'Monday',    'input' => ['week' => 1, 'format' => 'l']],
            'pattern017' => ['expected' => 'Tuesday',   'input' => ['week' => 2, 'format' => 'l']],
            'pattern018' => ['expected' => 'Wednesday', 'input' => ['week' => 3, 'format' => 'l']],
            'pattern019' => ['expected' => 'Thursday',  'input' => ['week' => 4, 'format' => 'l']],
            'pattern020' => ['expected' => 'Friday',    'input' => ['week' => 5, 'format' => 'l']],
            'pattern021' => ['expected' => 'Saturday',  'input' => ['week' => 6, 'format' => 'l']],

            'pattern022' => ['expected' => 'Sun', 'input' => ['week' => '日曜日', 'format' => 'D']],
            'pattern023' => ['expected' => 'Mon', 'input' => ['week' => '月曜日', 'format' => 'D']],
            'pattern024' => ['expected' => 'Tue', 'input' => ['week' => '火曜日', 'format' => 'D']],
            'pattern025' => ['expected' => 'Wed', 'input' => ['week' => '水曜日', 'format' => 'D']],
            'pattern026' => ['expected' => 'Thu', 'input' => ['week' => '木曜日', 'format' => 'D']],
            'pattern027' => ['expected' => 'Fri', 'input' => ['week' => '金曜日', 'format' => 'D']],
            'pattern028' => ['expected' => 'Sat', 'input' => ['week' => '土曜日', 'format' => 'D']],
            'pattern029' => ['expected' => 'Sun', 'input' => ['week' => '日', 'format' => 'D']],
            'pattern030' => ['expected' => 'Mon', 'input' => ['week' => '月', 'format' => 'D']],
            'pattern031' => ['expected' => 'Tue', 'input' => ['week' => '火', 'format' => 'D']],
            'pattern032' => ['expected' => 'Wed', 'input' => ['week' => '水', 'format' => 'D']],
            'pattern033' => ['expected' => 'Thu', 'input' => ['week' => '木', 'format' => 'D']],
            'pattern034' => ['expected' => 'Fri', 'input' => ['week' => '金', 'format' => 'D']],
            'pattern035' => ['expected' => 'Sat', 'input' => ['week' => '土', 'format' => 'D']],
            'pattern036' => ['expected' => 'Sun', 'input' => ['week' => 0, 'format' => 'D']],
            'pattern037' => ['expected' => 'Mon', 'input' => ['week' => 1, 'format' => 'D']],
            'pattern038' => ['expected' => 'Tue', 'input' => ['week' => 2, 'format' => 'D']],
            'pattern039' => ['expected' => 'Wed', 'input' => ['week' => 3, 'format' => 'D']],
            'pattern040' => ['expected' => 'Thu', 'input' => ['week' => 4, 'format' => 'D']],
            'pattern041' => ['expected' => 'Fri', 'input' => ['week' => 5, 'format' => 'D']],
            'pattern042' => ['expected' => 'Sat', 'input' => ['week' => 6, 'format' => 'D']],
        ];
    }

    /**
     * @dataProvider dataProviderToEn
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToEn($expected, $input)
    {
        $this->assertSame(
            $expected,
            Week::toEn($input['week'], $input['format'])
        );
    }

    /**
     * 許容していないデータ型を指定.
     */
    public function testToEnException1()
    {
        $this->expectException(\InvalidArgumentException::class);
        Week::toEn(true, 'D');
    }

    /**
     * 許容していない値を指定（$week）.
     */
    public function testToEnException2()
    {
        $this->expectException(\InvalidArgumentException::class);
        Week::toEn(-1, 'D');
    }

    /**
     * 許容していない値を指定（$week）.
     */
    public function testToEnException3()
    {
        $this->expectException(\InvalidArgumentException::class);
        Week::toEn('曜日', 'D');
    }

    /**
     * 許容していない値を指定（$format）.
     */
    public function testToEnException4()
    {
        $this->expectException(\InvalidArgumentException::class);
        Week::toEn(0, 'a');
    }
}
