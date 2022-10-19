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
use Selen\Schema\Validate\Values\MinSize;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\MinSize
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Values
 * @group Selen/Schema/Validate/Values/MinSize
 *
 * @see \Selen\Schema\Validate\Values\MinSize
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Values/MinSize
 *
 * @internal
 */
class MinSizeTest extends TestCase
{
    /**
     * 不正な範囲値を指定したときのテスト
     */
    public function testExecuteException1()
    {
        $stub = new ValidateResult();

        $size  = -1;
        $value = [];

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Invalid value. Values less than 0 cannot be specified.');
        (new MinSize($size))->execute($value, $stub);
    }

    /**
     * 対応していない値のバリデーションを実行したときのテスト
     */
    public function testExecuteException2()
    {
        $stub = new ValidateResult();

        $size  = 5;
        $value = 10;

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Not supported. Validation that can only support array type.');
        (new MinSize($size))->execute($value, $stub);
    }

    public function dataProviderExecute()
    {
        return [
            'pattern001' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Please specify an array of 5 or more elements.'),
                'input'    => [
                    'size'  => 5,
                    'value' => [1, 2, 3, 4],
                ],
            ],
            'pattern002' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'size'  => 5,
                    'value' => [1, 2, 3, 4, 5],
                ],
            ],
            'pattern003' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'size'  => 5,
                    'value' => [1, 2, 3, 4, 5, 6],
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
            'size'  => $size,
            'value' => $value,
        ] = $input;

        $result = (new MinSize($size))->execute($value, $stub);
        $this->assertSame($expected->getResult(), $result->getResult());
        $this->assertSame($expected->getMessage(), $result->getMessage());
        $this->assertSame($expected->getArrayPath(), $result->getArrayPath());
    }
}
