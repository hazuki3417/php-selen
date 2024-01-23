<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Validator\Model;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Validator\Model\ValidateResult;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Validator\Model\ValidateResult
 *
 * @see ValidateResult
 *
 * @internal
 */
class ValidateResultTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(ValidateResult::class, new ValidateResult());
    }

    public function testSetResult(): void
    {
        $this->assertInstanceOf(ValidateResult::class, (new ValidateResult())->setResult(true));
    }

    public function testSetArrayPath(): void
    {
        $this->assertInstanceOf(ValidateResult::class, (new ValidateResult())->setArrayPath(''));
    }

    public function testSetMessage(): void
    {
        $this->assertInstanceOf(ValidateResult::class, (new ValidateResult())->setMessage(''));
    }

    public function testGetResult1(): void
    {
        $this->assertTrue((new ValidateResult())->getResult());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderGetResult(): array
    {
        return [
            'pattern001' => ['expected' => true,  'input' => true],
            'pattern002' => ['expected' => false, 'input' => false],
        ];
    }

    /**
     * @dataProvider dataProviderGetResult
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetResult2($expected, $input): void
    {
        $this->assertSame($expected, (new ValidateResult($input))->getResult());
    }

    /**
     * @dataProvider dataProviderGetResult
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetResult3($expected, $input): void
    {
        $instance = new ValidateResult();
        $this->assertSame($expected, $instance->setResult($input)->getResult());
    }

    public function testGetArrayPath1(): void
    {
        $this->assertSame('', (new ValidateResult())->getArrayPath());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderGetArrayPath(): array
    {
        return [
            'pattern001' => ['expected' => '',      'input' => ''],
            'pattern002' => ['expected' => 'aaaaa', 'input' => 'aaaaa'],
        ];
    }

    /**
     * @dataProvider dataProviderGetArrayPath
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetArrayPath2($expected, $input): void
    {
        $this->assertSame($expected, (new ValidateResult(true, $input))->getArrayPath());
    }

    /**
     * @dataProvider dataProviderGetArrayPath
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetArrayPath3($expected, $input): void
    {
        $instance = new ValidateResult();
        $this->assertSame($expected, $instance->setArrayPath($input)->getArrayPath());
    }

    public function testGetMessage1(): void
    {
        $this->assertSame('', (new ValidateResult())->getMessage());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderGetMessage(): array
    {
        return [
            'pattern001' => ['expected' => '',      'input' => ''],
            'pattern002' => ['expected' => 'aaaaa', 'input' => 'aaaaa'],
        ];
    }

    /**
     * @dataProvider dataProviderGetMessage
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetMessage2($expected, $input): void
    {
        $this->assertSame($expected, (new ValidateResult(true, '', $input))->getMessage());
    }

    /**
     * @dataProvider dataProviderGetMessage
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetMessage3($expected, $input): void
    {
        $instance = new ValidateResult();
        $this->assertSame($expected, $instance->setMessage($input)->getMessage());
    }
}
