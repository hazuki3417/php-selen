<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Test;

use PHPUnit\Framework\TestCase;
use Selen\Str\CaseName;

/**
 * @coversDefaultClass \Selen\Str\Case
 *
 * @group Selen/Str
 * @group Selen/Str/Case
 *
 * @see \Selen\Str\Case
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Str/Case
 *
 * @internal
 */
class CaseTest extends TestCase
{
    public function dataProviderKebab()
    {
        return [
            'pattern001' => ['expected' => '',                     'input' => ''],
            'pattern002' => ['expected' => 'case',                 'input' => 'Case'],
            'pattern003' => ['expected' => 'case',                 'input' => 'case'],
            'pattern004' => ['expected' => 'case',                 'input' => 'case_'],
            'pattern005' => ['expected' => 'case',                 'input' => 'case__'],
            'pattern006' => ['expected' => 'case',                 'input' => '_case'],
            'pattern007' => ['expected' => 'case',                 'input' => '__case'],
            'pattern008' => ['expected' => 'case',                 'input' => '_case_'],
            'pattern009' => ['expected' => 'case',                 'input' => '__case__'],
            'pattern010' => ['expected' => 'case',                 'input' => 'case-'],
            'pattern011' => ['expected' => 'case',                 'input' => 'case--'],
            'pattern012' => ['expected' => 'case',                 'input' => '-case'],
            'pattern013' => ['expected' => 'case',                 'input' => '--case'],
            'pattern014' => ['expected' => 'case',                 'input' => '-case-'],
            'pattern015' => ['expected' => 'case',                 'input' => '--case--'],
            'pattern016' => ['expected' => 'case',                 'input' => 'case '],
            'pattern017' => ['expected' => 'case',                 'input' => 'case  '],
            'pattern018' => ['expected' => 'case',                 'input' => ' case'],
            'pattern019' => ['expected' => 'case',                 'input' => '  case'],
            'pattern020' => ['expected' => 'case',                 'input' => ' case '],
            'pattern021' => ['expected' => 'case',                 'input' => '  case  '],
            'pattern022' => ['expected' => 'case-name',            'input' => 'CaseName'],
            'pattern023' => ['expected' => 'case-name',            'input' => 'caseName'],
            'pattern024' => ['expected' => 'case-n-name',          'input' => 'caseNName'],
            'pattern025' => ['expected' => 'case-name',            'input' => 'case Name'],
            'pattern026' => ['expected' => 'case-name',            'input' => 'case_name'],
            'pattern027' => ['expected' => 'case-name',            'input' => 'case__name'],
            'pattern028' => ['expected' => 'case-name',            'input' => 'case-name'],
            'pattern029' => ['expected' => 'case-name',            'input' => 'case--name'],
            'pattern030' => ['expected' => 'case-name',            'input' => 'case name'],
            'pattern031' => ['expected' => 'case-name',            'input' => 'case  name'],
            'pattern032' => ['expected' => 'case-name-conversion', 'input' => 'caseName_conversion'],
            'pattern033' => ['expected' => 'case-name-conversion', 'input' => 'case name_conversion'],
            'pattern034' => ['expected' => 'case-name-conversion', 'input' => 'case Name_conversion'],
        ];
    }

    /**
     * @dataProvider dataProviderKebab
     * @group Selen/Str/Case::kebab
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testKebab($expected, $input)
    {
        $this->assertEquals($expected, CaseName::kebab($input));
    }

    public function dataProviderSnake()
    {
        return [
            'pattern001' => ['expected' => '',                     'input' => ''],
            'pattern002' => ['expected' => 'case',                 'input' => 'Case'],
            'pattern003' => ['expected' => 'case',                 'input' => 'case'],
            'pattern004' => ['expected' => 'case',                 'input' => 'case_'],
            'pattern005' => ['expected' => 'case',                 'input' => 'case__'],
            'pattern006' => ['expected' => 'case',                 'input' => '_case'],
            'pattern007' => ['expected' => 'case',                 'input' => '__case'],
            'pattern008' => ['expected' => 'case',                 'input' => '_case_'],
            'pattern009' => ['expected' => 'case',                 'input' => '__case__'],
            'pattern010' => ['expected' => 'case',                 'input' => 'case-'],
            'pattern011' => ['expected' => 'case',                 'input' => 'case--'],
            'pattern012' => ['expected' => 'case',                 'input' => '-case'],
            'pattern013' => ['expected' => 'case',                 'input' => '--case'],
            'pattern014' => ['expected' => 'case',                 'input' => '-case-'],
            'pattern015' => ['expected' => 'case',                 'input' => '--case--'],
            'pattern016' => ['expected' => 'case',                 'input' => 'case '],
            'pattern017' => ['expected' => 'case',                 'input' => 'case  '],
            'pattern018' => ['expected' => 'case',                 'input' => ' case'],
            'pattern019' => ['expected' => 'case',                 'input' => '  case'],
            'pattern020' => ['expected' => 'case',                 'input' => ' case '],
            'pattern021' => ['expected' => 'case',                 'input' => '  case  '],
            'pattern022' => ['expected' => 'case_name',            'input' => 'CaseName'],
            'pattern023' => ['expected' => 'case_name',            'input' => 'caseName'],
            'pattern024' => ['expected' => 'case_n_name',          'input' => 'caseNName'],
            'pattern025' => ['expected' => 'case_name',            'input' => 'case Name'],
            'pattern026' => ['expected' => 'case_name',            'input' => 'case_name'],
            'pattern027' => ['expected' => 'case_name',            'input' => 'case__name'],
            'pattern028' => ['expected' => 'case_name',            'input' => 'case-name'],
            'pattern029' => ['expected' => 'case_name',            'input' => 'case--name'],
            'pattern030' => ['expected' => 'case_name',            'input' => 'case name'],
            'pattern031' => ['expected' => 'case_name',            'input' => 'case  name'],
            'pattern032' => ['expected' => 'case_name_conversion', 'input' => 'caseName_conversion'],
            'pattern033' => ['expected' => 'case_name_conversion', 'input' => 'case name_conversion'],
            'pattern034' => ['expected' => 'case_name_conversion', 'input' => 'case Name_conversion'],
        ];
    }

    /**
     * @dataProvider dataProviderSnake
     * @group Selen/Str/Case::snake
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testSnake($expected, $input)
    {
        $this->assertEquals($expected, CaseName::snake($input));
    }

    public function dataProviderPascal()
    {
        return [
            'pattern001' => ['expected' => '',                   'input' => ''],
            'pattern002' => ['expected' => 'Case',               'input' => 'Case'],
            'pattern003' => ['expected' => 'Case',               'input' => 'case'],
            'pattern004' => ['expected' => 'Case',               'input' => 'case_'],
            'pattern005' => ['expected' => 'Case',               'input' => 'case__'],
            'pattern006' => ['expected' => 'Case',               'input' => '_case'],
            'pattern007' => ['expected' => 'Case',               'input' => '__case'],
            'pattern008' => ['expected' => 'Case',               'input' => '_case_'],
            'pattern009' => ['expected' => 'Case',               'input' => '__case__'],
            'pattern010' => ['expected' => 'Case',               'input' => 'case-'],
            'pattern011' => ['expected' => 'Case',               'input' => 'case--'],
            'pattern012' => ['expected' => 'Case',               'input' => '-case'],
            'pattern013' => ['expected' => 'Case',               'input' => '--case'],
            'pattern014' => ['expected' => 'Case',               'input' => '-case-'],
            'pattern015' => ['expected' => 'Case',               'input' => '--case--'],
            'pattern016' => ['expected' => 'Case',               'input' => 'case '],
            'pattern017' => ['expected' => 'Case',               'input' => 'case  '],
            'pattern018' => ['expected' => 'Case',               'input' => ' case'],
            'pattern019' => ['expected' => 'Case',               'input' => '  case'],
            'pattern020' => ['expected' => 'Case',               'input' => ' case '],
            'pattern021' => ['expected' => 'Case',               'input' => '  case  '],
            'pattern022' => ['expected' => 'CaseName',           'input' => 'CaseName'],
            'pattern023' => ['expected' => 'CaseName',           'input' => 'caseName'],
            'pattern024' => ['expected' => 'CaseNName',          'input' => 'caseNName'],
            'pattern025' => ['expected' => 'CaseName',           'input' => 'case Name'],
            'pattern026' => ['expected' => 'CaseName',           'input' => 'case_name'],
            'pattern027' => ['expected' => 'CaseName',           'input' => 'case__name'],
            'pattern028' => ['expected' => 'CaseName',           'input' => 'case-name'],
            'pattern029' => ['expected' => 'CaseName',           'input' => 'case--name'],
            'pattern030' => ['expected' => 'CaseName',           'input' => 'case name'],
            'pattern031' => ['expected' => 'CaseName',           'input' => 'case  name'],
            'pattern032' => ['expected' => 'CaseNameConversion', 'input' => 'caseName_conversion'],
            'pattern033' => ['expected' => 'CaseNameConversion', 'input' => 'case name_conversion'],
            'pattern034' => ['expected' => 'CaseNameConversion', 'input' => 'case Name_conversion'],
        ];
    }

    /**
     * @dataProvider dataProviderPascal
     * @group Selen/Str/Case::pascal
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testPascal($expected, $input)
    {
        $this->assertEquals($expected, CaseName::pascal($input));
    }

    public function dataProviderCamel()
    {
        return [
            'pattern001' => ['expected' => '',                   'input' => ''],
            'pattern002' => ['expected' => 'case',               'input' => 'Case'],
            'pattern003' => ['expected' => 'case',               'input' => 'case'],
            'pattern004' => ['expected' => 'case',               'input' => 'case_'],
            'pattern005' => ['expected' => 'case',               'input' => 'case__'],
            'pattern006' => ['expected' => 'case',               'input' => '_case'],
            'pattern007' => ['expected' => 'case',               'input' => '__case'],
            'pattern008' => ['expected' => 'case',               'input' => '_case_'],
            'pattern009' => ['expected' => 'case',               'input' => '__case__'],
            'pattern010' => ['expected' => 'case',               'input' => 'case-'],
            'pattern011' => ['expected' => 'case',               'input' => 'case--'],
            'pattern012' => ['expected' => 'case',               'input' => '-case'],
            'pattern013' => ['expected' => 'case',               'input' => '--case'],
            'pattern014' => ['expected' => 'case',               'input' => '-case-'],
            'pattern015' => ['expected' => 'case',               'input' => '--case--'],
            'pattern016' => ['expected' => 'case',               'input' => 'case '],
            'pattern017' => ['expected' => 'case',               'input' => 'case  '],
            'pattern018' => ['expected' => 'case',               'input' => ' case'],
            'pattern019' => ['expected' => 'case',               'input' => '  case'],
            'pattern020' => ['expected' => 'case',               'input' => ' case '],
            'pattern021' => ['expected' => 'case',               'input' => '  case  '],
            'pattern022' => ['expected' => 'caseName',           'input' => 'CaseName'],
            'pattern023' => ['expected' => 'caseName',           'input' => 'caseName'],
            'pattern024' => ['expected' => 'caseNName',          'input' => 'caseNName'],
            'pattern025' => ['expected' => 'caseName',           'input' => 'case Name'],
            'pattern026' => ['expected' => 'caseName',           'input' => 'case_name'],
            'pattern027' => ['expected' => 'caseName',           'input' => 'case__name'],
            'pattern028' => ['expected' => 'caseName',           'input' => 'case-name'],
            'pattern029' => ['expected' => 'caseName',           'input' => 'case--name'],
            'pattern030' => ['expected' => 'caseName',           'input' => 'case name'],
            'pattern031' => ['expected' => 'caseName',           'input' => 'case  name'],
            'pattern032' => ['expected' => 'caseNameConversion', 'input' => 'caseName_conversion'],
            'pattern033' => ['expected' => 'caseNameConversion', 'input' => 'case name_conversion'],
            'pattern034' => ['expected' => 'caseNameConversion', 'input' => 'case Name_conversion'],
        ];
    }

    /**
     * @dataProvider dataProviderCamel
     * @group Selen/Str/Case::camel
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testCamel($expected, $input)
    {
        $this->assertEquals($expected, CaseName::camel($input));
    }

    public function dataProviderUpper()
    {
        return [
            'pattern001' => ['expected' => '',     'input' => ''],
            'pattern002' => ['expected' => 'CASE', 'input' => 'Case'],
            'pattern003' => ['expected' => 'CASE', 'input' => 'case'],
        ];
    }

    /**
     * @dataProvider dataProviderUpper
     * @group Selen/Str/Case::Upper
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testUpper($expected, $input)
    {
        $this->assertEquals($expected, CaseName::upper($input));
    }

    public function dataProviderLower()
    {
        return [
            'pattern001' => ['expected' => '',     'input' => ''],
            'pattern002' => ['expected' => 'case', 'input' => 'CASE'],
            'pattern003' => ['expected' => 'case', 'input' => 'Case'],
        ];
    }

    /**
     * @dataProvider dataProviderLower
     * @group Selen/Str/Case::Lower
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testLower($expected, $input)
    {
        $this->assertEquals($expected, CaseName::lower($input));
    }
}
