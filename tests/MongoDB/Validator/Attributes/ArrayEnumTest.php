<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Validator\Attributes;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Validator\Attributes\ArrayEnum;
use Selen\MongoDB\Validator\Model\ValidateResult;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Validator\Attributes\ArrayEnum
 *
 * @see ArrayEnum
 *
 * @internal
 */
class ArrayEnumTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new ArrayEnum();

        $this->assertInstanceOf(ArrayEnum::class, $instance);
    }

    public function dataProviderExecute()
    {
        return [
            'pattern001' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'type'  => [1, 2, 0, 4],
                    'value' => [1, 2, 0],
                ], ],
            'pattern002' => [
                'expected' => new ValidateResult(false, '', 'Invalid type. expected array element type 1, 2.'),
                'input'    => [
                    'type'  => [1, 2],
                    'value' => [1, 2, 1.0],
                ], ],
            'pattern003' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'type'  => ['value1', 'value2', 0],
                    'value' => ['value1', 'value2', 0],
                ], ],
            'pattern004' => [
                'expected' => new ValidateResult(false, '', 'Invalid type. expected array element type 0, true.'),
                'input'    => [
                    'type'  => [0, true],
                    'value' => ['value1', 'value2', 0, true],
                ], ],
            'pattern005' => [
                'expected' => new ValidateResult(false, '', 'Invalid type. expected array element type \'value\', 0.5.'),
                'input'    => [
                    'type'  => ['value', 0.5],
                    'value' => '',
                ], ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param ValidateResult $expected
     * @param mixed          $input
     */
    public function testExecute($expected, $input)
    {
        $validateResult = new ValidateResult();

        $instance = new ArrayEnum(...$input['type']);

        $verify = $instance->execute($input['value'], $validateResult);

        $this->assertInstanceOf(ValidateResult::class, $verify);
        $this->assertSame($expected->getResult(), $verify->getResult());
        $this->assertSame($expected->getMessage(), $verify->getMessage());
        $this->assertSame($expected->getArrayPath(), $verify->getArrayPath());
    }
}
