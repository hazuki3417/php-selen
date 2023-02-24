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
use Selen\Schema\Validate\Values\ArrayNotEmpty;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\ArrayNotEmpty
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Values
 * @group Selen/Schema/Validate/Values/ArrayNotEmpty
 *
 * @see \Selen\Schema\Validate\Values\ArrayNotEmpty
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Values/ArrayNotEmpty
 *
 * @internal
 */
class ArrayNotEmptyTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(ArrayNotEmpty::class, new ArrayNotEmpty());
    }

    public function dataProviderExecute()
    {
        return [
            'validDataType: value is array' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'value' => ['string'],
                ],
            ],
            'invalidDataType: value is not array' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of array type.'),
                'input'    => [
                    'value' => 1,
                ],
            ],
            'invalidDataType: value is array empty' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Must have at least one element.'),
                'input'    => [
                    'value' => [],
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
            'value' => $value,
        ] = $input;

        $actual = (new ArrayNotEmpty())->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
    }
}
