<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Values;

use LogicException;
use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\MaxLength;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\MaxLength
 *
 * @see MaxLength
 *
 * @internal
 */
class MaxLengthTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(MaxLength::class, new MaxLength(10));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderExecuteException(): array
    {
        return [
            'invalidDataType: argument value is not int or float' => [
                'expected' => [
                    'expectException'        => LogicException::class,
                    'expectExceptionMessage' => 'Invalid value. Values less than 0 cannot be specified.',
                ],
                'input' => [
                    'args'  => -1,
                    'value' => '12345',
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
    public function testExecuteException($expected, $input): void
    {
        [
            'args'  => $length,
            'value' => $value,
        ] = $input;

        [
            'expectException'        => $expectException,
            'expectExceptionMessage' => $expectExceptionMessage,
        ] = $expected;

        $this->expectException($expectException);
        $this->expectExceptionMessage($expectExceptionMessage);

        (new MaxLength($length))->execute($value, new ValidateResult());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderExecute(): array
    {
        return [
            'validDataType: value not subject to validation' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of string type'),
                'input'    => [
                    'args'  => 5,
                    'value' => null,
                ],
            ],
            'validDataType: less than specified length (half-width)' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => 5,
                    'value' => '1234',
                ],
            ],
            'validDataType: same as specified length (half-width)' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => 5,
                    'value' => '12345',
                ],
            ],
            'invalidDataType: greater than specified length (half-width)' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Please specify with a character string of 5 characters or less.'),
                'input'    => [
                    'args'  => 5,
                    'value' => '123456',
                ],
            ],
            'validDataType: less than specified length (full-width)' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => 5,
                    'value' => '１２３４',
                ],
            ],
            'validDataType: same as specified length (full-width)' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => 5,
                    'value' => '１２３４５',
                ],
            ],
            'invalidDataType: greater than specified length (full-width)' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Please specify with a character string of 5 characters or less.'),
                'input'    => [
                    'args'  => 5,
                    'value' => '１２３４５６',
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

        $actual = (new MaxLength($args)
            )->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
    }
}
