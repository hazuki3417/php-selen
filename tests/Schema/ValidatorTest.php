<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validator\Define\Test;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\ArrayDefine;
use Selen\Schema\Validate\Define;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validator;

/**
 * @coversDefaultClass \Selen\Schema\Validator
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validator
 *
 * @see \Selen\Schema\Validator
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validator
 *
 * @internal
 */
class ValidatorTest extends TestCase
{
    /**
     * NOTE: 入力値と期待値の定義が複雑なため、メソッド単位でテストパターンを記載
     *       dataProviderを使うと可読性が下がるため
     */

    /**
     * keyのバリデーションテスト（1次元配列）
     */
    public function testPattern000()
    {
        $expectedSuccess = false;
        $expectedValidateResults = [
            new ValidateResult(false, 'key1', 'key is required'),
            new ValidateResult(false, 'key2', 'key is required'),
            // new ValidateResult(true, 'key3'), key3はoptionalなのでkeyの検証は実施されないため、結果も存在しない
            // new ValidateResult(true, 'key4'), key4はoptionalなのでkeyの検証は実施されないため、結果も存在しない
        ];

        $define = new ArrayDefine(
            Define::key('key1', true),
            Define::key('key2', true),
            Define::key('key3', false),
            Define::key('key4', false)
        );

        $input = [];

        $validator = Validator::new();

        $result = $validator->arrayDefine($define)->execute($input);

        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * keyのバリデーションテスト（1次元配列）
     */
    public function testPattern001()
    {
        $expectedSuccess = true;
        $expectedValidateResults = [
            new ValidateResult(true, 'key1'),
            new ValidateResult(true, 'key2'),
            // new ValidateResult(true, 'key3'), key3はoptionalなのでkeyの検証は実施されないため、結果も存在しない
            // new ValidateResult(true, 'key4'), key4はoptionalなのでkeyの検証は実施されないため、結果も存在しない
        ];

        $define = new ArrayDefine(
            Define::key('key1', true),
            Define::key('key2', true),
            Define::key('key3', false),
            Define::key('key4', false)
        );

        $input = [
            'key1' => '0',
            'key2' => '0',
            'key3' => '0',
            // 'key4' => '0',
        ];

        $validator = Validator::new();

        $result = $validator->arrayDefine($define)->execute($input);

        $this->assertValidatorClass($expectedSuccess, $expectedValidateResults, $result);
    }

    /**
     * Validatorクラスの返り値を検証するメソッド
     *
     * @param bool $expectedSuccess
     * @param \Selen\Schema\Validate\Model\ValidateResult[] $expectedValidateResults
     * @param \Selen\Schema\Validate\Model\ValidatorResult $result
     */
    private function assertValidatorClass($expectedSuccess, $expectedValidateResults, $result)
    {
        $this->assertSame($expectedSuccess, $result->success());

        $verifyValidateResults = $result->getValidateResults();

        foreach ($expectedValidateResults as $index => $expectedValidateResult) {
            $this->assertArrayHasKey(
                $index,
                $verifyValidateResults,
                '検証値のValidateResultsと期待値のValidateResultsの件数が一致しません'
            );
            // keyが存在したら中身の検証を行う
            $verifyValidateResult = $verifyValidateResults[$index];
            $mes = \sprintf('index number: %s', $index);
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
