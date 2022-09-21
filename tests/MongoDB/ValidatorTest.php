<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema\ArrayValue;
use Selen\MongoDB\Attributes\Schema\Field;
use Selen\MongoDB\Attributes\Schema\InnerObject;
use Selen\MongoDB\Attributes\Schema\RootObject;
use Selen\MongoDB\Attributes\Schema\Value;
use Selen\MongoDB\Attributes\Validate\Type;
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

    public function testPattern001()
    {
        $expectedSuccess         = false;
        $expectedValidateResults = [
            new ValidateResult(true, 'id'),
            new ValidateResult(true, 'foreignId'),
            new ValidateResult(true, 'foreignId'),
            new ValidateResult(true, 'name'),
            new ValidateResult(true, 'name'),
            new ValidateResult(true, 'meta'),
            new ValidateResult(false, 'meta.mail', 'field is required.'),
            new ValidateResult(false, 'meta.tell1', 'field is required.'),
            new ValidateResult(false, 'meta.tell2', 'field is required.'),
            new ValidateResult(true, 'items'),
            new ValidateResult(true, 'items.[0].name'),
            new ValidateResult(true, 'items.[0].description'),
            new ValidateResult(false, 'items.[1].name', 'field is required.'),
            new ValidateResult(false, 'items.[1].description', 'field is required.'),
            new ValidateResult(true, 'createdAt'),
            new ValidateResult(true, 'updatedAt'),
        ];

        $input = [
            'id'        => '',
            'foreignId' => '',
            'name'      => '',
            'meta'      => '',
            'items'     => [
                [
                    'name'        => '',
                    'description' => '',
                ],
                [
                ],
            ],
            'createdAt' => '',
            'updatedAt' => '',
        ];

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

    /** @var MockInnerObjectClass1 */
    #[Field, Value(MockInnerObjectClass1::class)]
    public $meta;

    /** @var MockInnerObjectClass2[] */
    #[Field, ArrayValue(MockInnerObjectClass2::class)]
    public $items;

    /** @var \MongoDB\BSON\UTCDateTime */
    #[Field]
    public $createdAt;

    /** @var \MongoDB\BSON\UTCDateTime */
    #[Field]
    public $updatedAt;
}

#[InnerObject]
class MockInnerObjectClass1
{
    /** @var string */
    #[Field]
    public $mail = '';

    /** @var string */
    #[Field]
    public $tell1 = '';

    /** @var string */
    #[Field]
    public $tell2 = '';
}

#[InnerObject]
class MockInnerObjectClass2
{
    /** @var string */
    #[Field]
    public $name = '';

    /** @var string */
    #[Field]
    public $description = '';
}
