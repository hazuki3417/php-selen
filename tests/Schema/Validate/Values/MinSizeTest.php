<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Unit\Exchange\Values;

use LogicException;
use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\MinSize;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\MinSize
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Values
 * @group Selen/Schema/Validate/Values/MinSize
 *
 * @see \Selen\Schema\Validate\Values\MinSize
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Values/MinSize
 *
 * @internal
 */
class MinSizeTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(MinSize::class, new MinSize(10));
    }

    public function dataProviderExecuteException()
    {
        return [
            'invalidDataType: argument value is not int or float' => [
                'expected' => [
                    'expectException'        => LogicException::class,
                    'expectExceptionMessage' => 'Invalid value. Values less than 0 cannot be specified.',
                ],
                'input' => [
                    'size'  => -1,
                    'value' => [],
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
            'size'  => $size,
            'value' => $value,
        ] = $input;

        [
            'expectException'        => $expectException,
            'expectExceptionMessage' => $expectExceptionMessage,
        ] = $expected;

        $this->expectException($expectException);
        $this->expectExceptionMessage($expectExceptionMessage);

        (new MinSize($size))->execute($value, new ValidateResult());
    }

    public function dataProviderExecute()
    {
        return [
            'validDataType: value not subject to validation' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of array type'),
                'input'    => [
                    'size'  => 5,
                    'value' => null,
                ],
            ],
            'validDataType: greater than specified size' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'size'  => 5,
                    'value' => [1, 2, 3, 4, 5, 6],
                ],
            ],
            'validDataType: same as specified size' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'size'  => 5,
                    'value' => [1, 2, 3, 4, 5],
                ],
            ],
            'invalidDataType: smaller than the specified size' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Please specify an array of 5 or more elements.'),
                'input'    => [
                    'size'  => 5,
                    'value' => [1, 2, 3, 4],
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
            'size'  => $size,
            'value' => $value,
        ] = $input;

        $actual = (new MinSize($size))->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
    }
}
