<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Values;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\Max;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\Max
 *
 * @see Max
 *
 * @internal
 */
class MaxTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(Max::class, new Max(10));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderExecute(): array
    {
        return [
            'validDataType: value not subject to validation' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of type int or float'),
                'input'    => [
                    'args'  => 5,
                    'value' => null,
                ],
            ],
            'validDataType: less than args' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => 5,
                    'value' => 4,
                ],
            ],
            'validDataType: equivalent to args' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'args'  => 5,
                    'value' => 5,
                ],
            ],
            'invalidDataType: greater than args' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Specify a value of 5 or less.'),
                'input'    => [
                    'args'  => 5,
                    'value' => 6,
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

        $actual = (new Max($args))
            ->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
    }
}
