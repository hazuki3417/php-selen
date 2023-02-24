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
use Selen\Schema\Validate\Values\StrNotEmpty;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\StrNotEmpty
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Values
 * @group Selen/Schema/Validate/Values/StrNotEmpty
 *
 * @see \Selen\Schema\Validate\Values\StrNotEmpty
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Values/StrNotEmpty
 *
 * @internal
 */
/**
 * @internal
 *
 * @coversNothing
 */
class StrNotEmptyTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(StrNotEmpty::class, new StrNotEmpty());
    }

    public function dataProviderExecute()
    {
        return [
            'validDataType: value is string' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'value' => '0123456789',
                ],
            ],
            'invalidDataType: value is not string' => [
                'expected' => new ValidateResult(true, '', 'Skip validation. Executed only when the value is of string type.'),
                'input'    => [
                    'value' => 1,
                ],
            ],
            'invalidDataType: value is string empty' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. A string of at least 1 character is required.'),
                'input'    => [
                    'value' => '',
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

        $actual = (new StrNotEmpty())->execute($value, new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
    }
}
