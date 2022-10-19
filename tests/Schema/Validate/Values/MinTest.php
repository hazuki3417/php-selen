<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Unit\Exchange\Values;

use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\Min;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\Min
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Values
 * @group Selen/Schema/Validate/Values/Min
 *
 * @see \Selen\Schema\Validate\Values\Min
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Values/Min
 *
 * @internal
 */
class MinTest extends TestCase
{
    /**
     * 不正な範囲値を指定したときのテスト
     */
    public function testExecuteException1()
    {
        $stub = new ValidateResult();

        $threshold = '5';
        $value     = 6;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value. Please specify int or float type.');
        (new Min($threshold))->execute($value, $stub);
    }

    /**
     * 対応していない値のバリデーションを実行したときのテスト
     */
    public function testExecuteException2()
    {
        $stub = new ValidateResult();

        $threshold = 5;
        $value     = '6';

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Not supported. Validation that supports int and float types.');
        (new Min($threshold))->execute($value, $stub);
    }

    public function dataProviderExecute()
    {
        return [
            'pattern001' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'threshold' => 5,
                    'value'     => 6,
                ],
            ],
            'pattern002' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'threshold' => 5,
                    'value'     => 5,
                ],
            ],
            'pattern003' => [
                'expected' => new ValidateResult(false, '', 'Invalid value. Specify a value of 5 or greater.'),
                'input'    => [
                    'threshold' => 5,
                    'value'     => 4,
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
            'threshold' => $threshold,
            'value'     => $value,
        ] = $input;

        $result = (new Min($threshold))->execute($value, $stub);
        $this->assertSame($expected->getResult(), $result->getResult());
        $this->assertSame($expected->getMessage(), $result->getMessage());
        $this->assertSame($expected->getArrayPath(), $result->getArrayPath());
    }
}
