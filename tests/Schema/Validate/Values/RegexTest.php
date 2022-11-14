<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Values;

use LogicException;
use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\Regex;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\Regex
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Values
 * @group Selen/Schema/Validate/Values/Regex
 *
 * @see \Selen\Schema\Validate\Values\Regex
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Values/Regex
 *
 * @internal
 */
class RegexTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Regex::class, new Regex('^[0-9]$'));
    }

    public function dataProviderExecuteException()
    {
        return [
            'invalidDataType: value is not string type' => [
                'expected' => [
                    'expectException'        => LogicException::class,
                    'expectExceptionMessage' => 'Not supported. Validation that can only support string type.',
                ],
                'input' => [
                    'pattern' => '^[0-9]+$',
                    'value'   => 10,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExecuteException
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testExecuteException($expected, $input)
    {
        [
            'pattern' => $pattern,
            'value'   => $value,
        ] = $input;

        [
            'expectException'        => $expectException,
            'expectExceptionMessage' => $expectExceptionMessage,
        ] = $expected;

        $instance = new Regex($pattern);

        $this->expectException($expectException);
        $this->expectExceptionMessage($expectExceptionMessage);

        $instance->execute($value, new ValidateResult());
    }

    public function dataProviderExecute()
    {
        return [
            "validDataType: value is '10'" => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'pattern' => '^[0-9]+$',
                    'value'   => '10',
                ], ],
            "invalidDataType: value is 'a'" => [
                'expected' => new ValidateResult(false, '', 'Invalid value. expected value ^[0-9]+$.'),
                'input'    => [
                    'pattern' => '^[0-9]+$',
                    'value'   => 'a',
                ], ],
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

        $instance = new Regex($pattern);
        $verify   = $instance->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $verify);
        $this->assertSame($expected->getResult(), $verify->getResult());
        $this->assertSame($expected->getArrayPath(), $verify->getArrayPath());
        $this->assertSame($expected->getMessage(), $verify->getMessage());
    }
}
