<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Attribute;

use LogicException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Selen\MongoDB\Attribute\SchemaFieldLoader;
use Selen\MongoDB\Attributes\SchemaField;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Attribute\SchemaFieldLoader
 *
 * @see SchemaFieldLoader
 *
 * @internal
 */
class SchemaFieldLoaderTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderConstruct(): array
    {
        $reflectionClass = new ReflectionClass(SchemaFieldLoaderTestMockObject::class);
        return [
            'pattern001' => [
                'excepted' => SchemaFieldLoader::class,
                'input'    => $reflectionClass->getProperty('property1'),
            ],
            'pattern002' => [
                'excepted' => SchemaFieldLoader::class,
                'input'    => $reflectionClass->getProperty('property2'),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderConstruct
     *
     * @param mixed               $expected
     * @param \ReflectionProperty $input
     */
    public function testConstruct($expected, $input): void
    {
        $instance = new SchemaFieldLoader($input);
        $this->assertInstanceOf($expected, $instance);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderConstructException(): array
    {
        $reflectionClass = new ReflectionClass(SchemaFieldLoaderTestMockObject::class);
        return [
            'pattern001' => [
                'excepted' => LogicException::class,
                'input'    => $reflectionClass->getProperty('property3'),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderConstructException
     *
     * @param mixed               $expected
     * @param \ReflectionProperty $input
     */
    public function testConstructException($expected, $input): void
    {
        $this->expectException($expected);
        new SchemaFieldLoader($input);
    }
}

class SchemaFieldLoaderTestMockObject
{
    public $property1;

    #[SchemaField]
    public $property2;

    // @phpstan-ignore-next-line 例外テスト実施のためphpstanを無効化
    #[SchemaField, SchemaField]
    public $property3;
}
