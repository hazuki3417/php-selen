<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Validator;

use PHPUnit\Framework\TestCase;
use Selen\Data\ArrayPath;
use Selen\MongoDB\Validator\Key;
use Selen\MongoDB\Validator\Model\ValidateResult;
use Selen\MongoDB\Validator\Model\ValidatorResult;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Validator\Key
 *
 * @group Selen/MongoDB/Validator/Key
 *
 * @see \Selen\MongoDB\Validator\Key
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Validator/Key
 *
 * @internal
 */
class KeyTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Key(new ArrayPath());
        $this->assertInstanceOf(Key::class, $instance);
    }

    public function dataProviderExecute()
    {
        return [
            'pattern001' => [
                'expected' => [
                    'success'            => false,
                    'getValidateResults' => [
                        new ValidateResult(false, 'keyName', 'field is required.'),
                    ],
                ],
                'input' => [
                    'key'   => 'keyName',
                    'input' => [],
                ],
            ],
            'pattern002' => [
                'expected' => [
                    'success'            => true,
                    'getValidateResults' => [
                        new ValidateResult(true, 'keyName'),
                    ],
                ],
                'input' => [
                    'key'   => 'keyName',
                    'input' => ['keyName' => ''],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testExecute($expected, $input)
    {
        [
            'key'   => $key,
            'input' => $input,
        ] = $input;

        $arrayPath = new ArrayPath();

        $arrayPath->down();

        $instance = new Key($arrayPath);
        $verify   = $instance->execute($key, $input);

        $this->assertInstanceOf(ValidatorResult::class, $verify);

        [
            'success'            => $expectedSuccess,
            'getValidateResults' => $expectedGetValidateResults,
        ] = $expected;

        $this->assertValidatorResultClass($expectedSuccess, $expectedGetValidateResults, $verify);
    }

    /**
     * ValidatorResultクラスの返り値を検証するメソッド
     *
     * @param bool $expectedSuccess
     * @param array $expectedValidateResults
     * @param mixed $actual
     */
    public function assertValidatorResultClass($expectedSuccess, $expectedValidateResults, $actual)
    {
        $this->assertSame($expectedSuccess, $actual->success());

        $verifyValidateResults = $actual->getValidateResults();

        $this->assertSame(
            count($expectedValidateResults),
            count($verifyValidateResults),
            '検証値のValidateResultsと期待値のValidateResultsの件数が一致しません'
        );

        foreach ($expectedValidateResults as $index => $expectedValidateResult) {
            // keyが存在したら中身の検証を行う
            $verifyValidateResult = $verifyValidateResults[$index];
            $mes                  = \sprintf('Failure index number: %s', $index);
            $this->assertSame(
                $expectedValidateResult->getResult(),
                $verifyValidateResult->getResult(),
                $mes
            );
            $this->assertSame(
                $expectedValidateResult->getArrayPath(),
                $verifyValidateResult->getArrayPath(),
                $mes
            );
            $this->assertSame(
                $expectedValidateResult->getMessage(),
                $verifyValidateResult->getMessage(),
                $mes
            );
        }
    }
}
