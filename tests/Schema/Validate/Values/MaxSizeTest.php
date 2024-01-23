<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Values;

use LogicException;
use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\MaxSize;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\MaxSize
 *
 * @see MaxSize
 *
 * @internal
 */
class MaxSizeTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(MaxSize::class, new MaxSize(10));
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
    public function testExecuteException($expected, $input): void
    {
        [
            'args'  => $args,
            'value' => $value,
        ] = $input;

        [
            'expectException'        => $expectException,
            'expectExceptionMessage' => $expectExceptionMessage,
        ] = $expected;

        $this->expectException($expectException);
        $this->expectExceptionMessage($expectExceptionMessage);

        (new MaxSize($args))->execute($value, new ValidateResult());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderExecute(): array
    {
        return [
            'validDataType: value not subject to validation' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of array type'),
                'input'    => [
                    'args'  => 5,
                    'value' => null,
                ],
            ],
            'validDataType: smaller than the specified args' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => 5,
                    'value' => [1, 2, 3, 4],
                ],
            ],
            'validDataType: same as specified args' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => 5,
                    'value' => [1, 2, 3, 4, 5],
                ],
            ],
            'invalidDataType: greater than specified args' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Specify an array with 5 or less elements.'),
                'input'    => [
                    'args'  => 5,
                    'value' => [1, 2, 3, 4, 5, 6],
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

        $actual = (new MaxSize($args))
            ->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
    }
}
