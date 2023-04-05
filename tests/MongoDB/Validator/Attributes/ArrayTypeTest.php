<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Validator\Attributes;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Validator\Attributes\ArrayType;
use Selen\MongoDB\Validator\Model\ValidateResult;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Validator\Attributes\ArrayType
 *
 * @see \Selen\MongoDB\Validator\Attributes\ArrayType
 *
 * @internal
 */
class ArrayTypeTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new ArrayType();

        $this->assertInstanceOf(ArrayType::class, $instance);
    }

    public function dataProviderExecute()
    {
        return [
            'pattern001' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'type'  => ['int'],
                    'value' => [1, 2, 0],
                ], ],
            'pattern002' => [
                'expected' => new ValidateResult(false, '', 'Invalid type. expected array element type int.'),
                'input'    => [
                    'type'  => ['int'],
                    'value' => [1, 2, 1.0],
                ], ],
            'pattern003' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'type'  => ['int', 'string'],
                    'value' => ['value1', 'value2', 0],
                ], ],
            'pattern004' => [
                'expected' => new ValidateResult(false, '', 'Invalid type. expected array element type int, string.'),
                'input'    => [
                    'type'  => ['int', 'string'],
                    'value' => ['value1', 'value2', 0, true],
                ], ],
            'pattern005' => [
                'expected' => new ValidateResult(false, '', 'Invalid type. expected array element type int, string.'),
                'input'    => [
                    'type'  => ['int', 'string'],
                    'value' => '',
                ], ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param \Selen\MongoDB\Validator\Model\ValidateResult $expected
     * @param mixed $input
     */
    public function testExecute($expected, $input)
    {
        $validateResult = new ValidateResult();

        $instance = new ArrayType(...$input['type']);

        $verify = $instance->execute($input['value'], $validateResult);

        $this->assertInstanceOf(ValidateResult::class, $verify);
        $this->assertSame($expected->getResult(), $verify->getResult());
        $this->assertSame($expected->getMessage(), $verify->getMessage());
        $this->assertSame($expected->getArrayPath(), $verify->getArrayPath());
    }
}
