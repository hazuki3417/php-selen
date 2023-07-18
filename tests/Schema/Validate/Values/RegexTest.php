<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Values;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\Regex;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\Regex
 *
 * @see \Selen\Schema\Validate\Values\Regex
 *
 * @internal
 */
class RegexTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Regex::class, new Regex('^[0-9]$'));
    }

    public function dataProviderExecute()
    {
        return [
            'validDataType: value not subject to validation' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of string type'),
                'input'    => [
                    'pattern' => '^[0-9]+$',
                    'value'   => null,
                ],
            ],
            'validDataType: matches a regular expression' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'pattern' => '^[0-9]+$',
                    'value'   => '10',
                ],
            ],
            'invalidDataType: does not match regular expression' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value pattern ^[0-9]+$.'),
                'input'    => [
                    'pattern' => '^[0-9]+$',
                    'value'   => 'a',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param \Selen\Schema\Validate\Model\ValidateResult $expected
     * @param mixed $input
     */
    public function testExecute($expected, $input)
    {
        [
            'pattern' => $pattern,
            'value'   => $value,
        ] = $input;

        $actual = (new Regex($pattern))->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
    }
}
