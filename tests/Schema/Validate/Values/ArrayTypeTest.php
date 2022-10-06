<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Values\ArrayType;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\ArrayType;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\Schema\Validate\Values\ArrayType
 *
 * @group Selen/Schema/Validate/Values/ArrayType
 *
 * @see \Selen\Schema\Validate\Values\ArrayType
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Values/ArrayType
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
        $instance = new ArrayType(...$input['type']);
        $verify   = $instance->execute($input['value'], new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $verify);
        $this->assertSame($expected->getResult(), $verify->getResult());
        $this->assertSame($expected->getMessage(), $verify->getMessage());
        $this->assertSame($expected->getArrayPath(), $verify->getArrayPath());
    }
}
