<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema\Field;
use Selen\MongoDB\Attributes\Schema\RootObject;
use Selen\MongoDB\Attributes\Schema\Value;
use Selen\MongoDB\Attributes\Type;
use Selen\MongoDB\Validate\Model\ValidateResult;
use Selen\MongoDB\Validate\Model\ValidatorResult;
use Selen\MongoDB\Validator;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\Validator
 *
 * @group Selen
 * @group Selen/MongoDB
 * @group Selen/MongoDB/Validator
 *
 * @see \Selen\MongoDB\Validator
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Validator
 *
 * @internal
 *
 * NOTE: 下記クラスのstubを作るとエラーが発生するため、本体のクラスをstubとして利用
 *
 * @see \ReflectionClass
 */
class ValidatorTest extends TestCase
{
    public function testConstruct()
    {
        $instance = Validator::new();
        $this->assertInstanceOf(Validator::class, $instance);
    }

    public function testPattern000()
    {
        $expectedSuccess         = false;
        $expectedValidateResults = [
            new ValidateResult(false, 'id', 'field is required.'),
            new ValidateResult(false, 'foreignId', 'field is required.'),
            new ValidateResult(false, 'name', 'field is required.'),
            new ValidateResult(false, 'meta', 'field is required.'),
            new ValidateResult(false, 'items', 'field is required.'),
            new ValidateResult(false, 'createdAt', 'field is required.'),
            new ValidateResult(false, 'updatedAt', 'field is required.'),
        ];

        $input = [];

        $validator = Validator::new();
        $result    = $validator->schema(MockRootObjectClass::class)->execute($input);
        $this->assertInstanceOf(ValidatorResult::class, $result);
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

#[RootObject]
class MockRootObjectClass
{
    /** @var \MongoDB\BSON\ObjectId */
    #[Field]
    public $id;

    /** @var string */
    #[Field, Type('string')]
    public $foreignId = '';

    /** @var string */
    #[Field, Type('string')]
    public $name = '';

    /** @var MockValueClass1 */
    #[Field, Type(MockValueClass1::class)]
    public $meta;

    /** @var MockValueClass2 */
    #[Field, Type(MockValueClass2::class)]
    public $items;

    /** @var \MongoDB\BSON\UTCDateTime */
    #[Field]
    public $createdAt;

    /** @var \MongoDB\BSON\UTCDateTime */
    #[Field]
    public $updatedAt;
}

#[Value]
class MockValueClass1
{
    /** @var string */
    #[Field, Type('string')]
    public $mail = '';

    /** @var string */
    #[Field, Type('string')]
    public $tell1 = '';

    /** @var string */
    #[Field, Type('string')]
    public $tell2 = '';
}

#[Value]
class MockValueClass2
{
    /** @var string */
    #[Field, Type('string')]
    public $name = '';

    /** @var string */
    #[Field, Type('string')]
    public $description = '';
}
