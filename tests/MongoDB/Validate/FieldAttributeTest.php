<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validate\FieldAttribute\Test;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Selen\MongoDB\Attributes\Schema\Field;
use Selen\MongoDB\Attributes\Validate\Type;
use Selen\MongoDB\Validate\FieldAttribute;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Validate\FieldAttribute
 *
 * @group Selen
 * @group Selen/MongoDB
 * @group Selen/MongoDB/Validate
 * @group Selen/MongoDB/Validate/FieldAttribute
 *
 * @see \Selen\MongoDB\Validate\FieldAttribute
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Validate/FieldAttribute
 *
 * @internal
 *
 * NOTE: 下記クラスのstubを作るとエラーが発生するため、本体のクラスをstubとして利用
 *
 * @see \ReflectionClass
 */
class FieldAttributeTest extends TestCase
{
    public function testConstruct()
    {
        $reflectionClass = new ReflectionClass(MockClass::class);
        $instance        = new FieldAttribute($reflectionClass->getProperty('property1'));
        $this->assertInstanceOf(FieldAttribute::class, $instance);
    }

    public function testGetFieldName()
    {
        $reflectionClass = new ReflectionClass(MockClass::class);
        $instance        = new FieldAttribute($reflectionClass->getProperty('property1'));
        $this->assertSame('property1', $instance->getFieldName());
    }

    public function dataProviderIsValidateAttributeExists()
    {
        $reflectionClass = new ReflectionClass(MockClass::class);
        return [
            'pattern001' => [
                'expected' => false,
                'input'    => $reflectionClass->getProperty('property1'),
            ],
            'pattern002' => [
                'expected' => false,
                'input'    => $reflectionClass->getProperty('property2'),
            ],
            'pattern003' => [
                'expected' => true,
                'input'    => $reflectionClass->getProperty('property3'),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderIsValidateAttributeExists
     *
     * @param bool $expected
     * @param \ReflectionProperty
     * @param mixed $input
     */
    public function testIsValidateAttributeExists($expected, $input)
    {
        $instance = new FieldAttribute($input);
        $this->assertSame($expected, $instance->isValidateAttributeExists());
    }
}

class MockClass
{
    #[Field]
    public $property1;
    #[Field]
    public $property2;
    #[Field, Type('string')]
    public $property3;
}
