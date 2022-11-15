<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Unit\Exchange\Values;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\Max;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\Max
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Values
 * @group Selen/Schema/Validate/Values/Max
 *
 * @see \Selen\Schema\Validate\Values\Max
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Values/Max
 *
 * @internal
 */
class MaxTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Max::class, new Max(10));
    }

    public function dataProviderExecuteException()
    {
        return [
            'invalidDataType: argument value is not int or float' => [
                'expected' => [
                    'expectException'        => InvalidArgumentException::class,
                    'expectExceptionMessage' => 'Invalid value. Please specify int or float type.',
                ],
                'input' => [
                    'threshold' => '5',
                    'value'     => 4,
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
            'threshold' => $threshold,
            'value'     => $value,
        ] = $input;

        [
            'expectException'        => $expectException,
            'expectExceptionMessage' => $expectExceptionMessage,
        ] = $expected;

        $this->expectException($expectException);
        $this->expectExceptionMessage($expectExceptionMessage);

        (new Max($threshold))->execute($value, new ValidateResult());
    }

    public function dataProviderExecute()
    {
        return [
            'validDataType: value not subject to validation' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of type int or float'),
                'input'    => [
                    'threshold' => 5,
                    'value'     => null,
                ],
            ],
            'validDataType: less than threshold' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'threshold' => 5,
                    'value'     => 4,
                ],
            ],
            'validDataType: equivalent to threshold' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'threshold' => 5,
                    'value'     => 5,
                ],
            ],
            'invalidDataType: greater than threshold' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Specify a value of 5 or less.'),
                'input'    => [
                    'threshold' => 5,
                    'value'     => 6,
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
            'threshold' => $threshold,
            'value'     => $value,
        ] = $input;

        $actual = (new Max($threshold))->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
    }
}
