<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Model;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Model\ValidatorResult;

/**
 * @coversDefaultClass \Selen\Validate\Model\ValidatorResult
 *
 * @see ValidatorResult
 *
 * @internal
 */
class ValidatorResultTest extends TestCase
{
    public function testConstruct1(): void
    {
        $validateResultStub = $this->createStub(ValidateResult::class);
        $instance           = new ValidatorResult($validateResultStub);
        $this->assertInstanceOf(ValidatorResult::class, $instance);
    }

    public function testConstruct2(): void
    {
        $validateResultStub1 = $this->createStub(ValidateResult::class);
        $validateResultStub2 = $this->createStub(ValidateResult::class);
        $instance            = new ValidatorResult($validateResultStub1, $validateResultStub2);
        $this->assertInstanceOf(ValidatorResult::class, $instance);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderSuccess(): array
    {
        $successValidateResultStub = $this->createSuccessValidateResultStub();
        $failureValidateResultStub = $this->createFailureValidateResultStub();

        return [
            // バリデーション結果：合格1件、違反0件
            'pattern001' => [
                'expected' => true,
                'input'    => [
                    $successValidateResultStub,
                ],
            ],
            // バリデーション結果：合格0件、違反1件
            'pattern002' => [
                'expected' => false,
                'input'    => [
                    $failureValidateResultStub,
                ],
            ],
            // バリデーション結果：合格2件、違反0件
            'pattern003' => [
                'expected' => true,
                'input'    => [
                    $successValidateResultStub,
                    $successValidateResultStub,
                ],
            ],
            // バリデーション結果：合格0件、違反2件
            'pattern004' => [
                'expected' => false,
                'input'    => [
                    $failureValidateResultStub,
                    $failureValidateResultStub,
                ],
            ],
            // バリデーション結果：合格1件、違反1件
            'pattern005' => [
                'expected' => false,
                'input'    => [
                    $successValidateResultStub,
                    $failureValidateResultStub,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderSuccess
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testSuccess($expected, $input): void
    {
        $instance = new ValidatorResult(...$input);
        $this->assertSame($expected, $instance->success());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderFailure(): array
    {
        $successValidateResultStub = $this->createSuccessValidateResultStub();
        $failureValidateResultStub = $this->createFailureValidateResultStub();

        return [
            // バリデーション結果：合格1件、違反0件
            'pattern001' => [
                'expected' => false,
                'input'    => [
                    $successValidateResultStub,
                ],
            ],
            // バリデーション結果：合格0件、違反1件
            'pattern002' => [
                'expected' => true,
                'input'    => [
                    $failureValidateResultStub,
                ],
            ],
            // バリデーション結果：合格2件、違反0件
            'pattern003' => [
                'expected' => false,
                'input'    => [
                    $successValidateResultStub,
                    $successValidateResultStub,
                ],
            ],
            // バリデーション結果：合格0件、違反2件
            'pattern004' => [
                'expected' => true,
                'input'    => [
                    $failureValidateResultStub,
                    $failureValidateResultStub,
                ],
            ],
            // バリデーション結果：合格1件、違反1件
            'pattern005' => [
                'expected' => true,
                'input'    => [
                    $successValidateResultStub,
                    $failureValidateResultStub,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderFailure
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testFailure($expected, $input): void
    {
        $instance = new ValidatorResult(...$input);
        $this->assertSame($expected, $instance->failure());
    }

    public function testGetValidateResults(): void
    {
        $validateResultStub1 = $this->createStub(ValidateResult::class);
        $validateResultStub2 = $this->createStub(ValidateResult::class);
        $instance            = new ValidatorResult($validateResultStub1, $validateResultStub2);

        $validateResults = $instance->getValidateResults();
        $this->assertIsArray($validateResults);
    }

    private function createSuccessValidateResultStub()
    {
        $stub = $this->createStub(ValidateResult::class);
        $stub->method('getResult')->willReturn(true);
        return $stub;
    }

    private function createFailureValidateResultStub()
    {
        $stub = $this->createStub(ValidateResult::class);
        $stub->method('getResult')->willReturn(false);
        return $stub;
    }
}
