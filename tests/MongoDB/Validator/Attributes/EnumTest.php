<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Validator\Attributes;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Validator\Attributes\Enum;
use Selen\MongoDB\Validator\Model\ValidateResult;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Validator\Attributes\Enum
 *
 * @see \Selen\MongoDB\Validator\Attributes\Enum
 *
 * @internal
 */
class EnumTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Enum::class, new Enum('string'));
    }

    public function dataProviderExecute()
    {
        return [
            'pattern001' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'type'  => ['main', 'sub'],
                    'value' => 'main',
                ],
            ],
            'pattern002' => [
                'expected' => new ValidateResult(false, '', "Invalid value. Expected value 'main', 'sub'."),
                'input'    => [
                    'type'  => ['main', 'sub'],
                    'value' => 'mai',
                ],
            ],
            'pattern003' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'type'  => ['main', 'sub', true, 0],
                    'value' => 'sub',
                ],
            ],
            'pattern004' => [
                'expected' => new ValidateResult(false, '', "Invalid value. Expected value 'main', true, 0."),
                'input'    => [
                    'type'  => ['main', true, 0],
                    'value' => [],
                ],
            ],
            'pattern005' => [
                'expected' => new ValidateResult(false, '', "Invalid value. Expected value 'main', true, null."),
                'input'    => [
                    'type'  => ['main', true, null],
                    'value' => [],
                ],
            ],
            'pattern006' => [
                'expected' => new ValidateResult(false, '', "Invalid value. Expected value 'main', false, 0.1."),
                'input'    => [
                    'type'  => ['main', false, 0.1],
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
        $actual = (new Enum(...$input['type']))->execute($input['value'], new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
    }
}
