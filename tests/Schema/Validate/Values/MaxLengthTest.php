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
use Selen\Schema\Validate\Values\MaxLength;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\MaxLength
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Values
 * @group Selen/Schema/Validate/Values/MaxLength
 *
 * @see \Selen\Schema\Validate\Values\MaxLength
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Values/MaxLength
 *
 * @internal
 */
class MaxLengthTest extends TestCase
{
    /**
     * 不正な範囲値を指定したときのテスト
     */
    public function testExecuteException1()
    {
        $stub = new ValidateResult();

        $length = -1;
        $value  = [];

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Invalid value. Values less than 0 cannot be specified.');
        (new MaxLength($length))->execute($value, $stub);
    }

    /**
     * 対応していない値のバリデーションを実行したときのテスト
     */
    public function testExecuteException2()
    {
        $stub = new ValidateResult();

        $length = 5;
        $value  = 10;

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Not supported. Validation that can only support string type.');
        (new MaxLength($length))->execute($value, $stub);
    }

    public function dataProviderExecute()
    {
        return [
            'pattern001' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'length' => 5,
                    'value'  => '1234',
                ],
            ],
            'pattern002' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'length' => 5,
                    'value'  => '12345',
                ],
            ],
            'pattern003' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Please specify with a character string of 5 characters or less.'),
                'input'    => [
                    'length' => 5,
                    'value'  => '123456',
                ],
            ],
            'pattern004' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'length' => 5,
                    'value'  => '１２３４',
                ],
            ],
            'pattern005' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'length' => 5,
                    'value'  => '１２３４５',
                ],
            ],
            'pattern006' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Please specify with a character string of 5 characters or less.'),
                'input'    => [
                    'length' => 5,
                    'value'  => '１２３４５６',
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
        $stub = new ValidateResult();
        [
            'length' => $length,
            'value'  => $value,
        ] = $input;

        $result = (new MaxLength($length))->execute($value, $stub);
        $this->assertSame($expected->getResult(), $result->getResult());
        $this->assertSame($expected->getMessage(), $result->getMessage());
        $this->assertSame($expected->getArrayPath(), $result->getArrayPath());
    }
}
