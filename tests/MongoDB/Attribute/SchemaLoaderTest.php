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
use Selen\MongoDB\Attribute\SchemaLoader;
use Selen\MongoDB\Attributes\Schema;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Attribute\SchemaLoader
 *
 * @group Selen
 * @group Selen/MongoDB
 * @group Selen/MongoDB/Attribute
 * @group Selen/MongoDB/Attribute/SchemaLoader
 *
 * @see \Selen\MongoDB\Attribute\SchemaLoader
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attribute/SchemaLoader
 *
 * @internal
 */
class SchemaLoaderTest extends TestCase
{
    public function dataProviderConstruct()
    {
        return [
            'pattern001' => [
                'expected' => SchemaLoader::class,
                'input'    => new ReflectionClass(SchemaLoaderTestMockRootObject::class),
            ],
            'pattern002' => [
                'expected' => SchemaLoader::class,
                'input'    => new ReflectionClass(SchemaLoaderTestMockInnerObject::class),
            ],
            'pattern003' => [
                'expected' => SchemaLoader::class,
                'input'    => new ReflectionClass(SchemaLoaderTestMockObject::class),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderConstruct
     *
     * @param mixed $expected
     * @param \ReflectionClass $input
     */
    public function testConstruct($expected, $input)
    {
        $instance = new SchemaLoader($input);
        $this->assertInstanceOf($expected, $instance);
    }

    public function dataProviderConstructException()
    {
        return [
            'pattern001' => [
                'expected' => LogicException::class,
                'input'    => new ReflectionClass(SchemaLoaderTestMockException2::class),
            ],
            'pattern002' => [
                'expected' => LogicException::class,
                'input'    => new ReflectionClass(SchemaLoaderTestMockException3::class),
            ],
            'pattern003' => [
                'expected' => LogicException::class,
                'input'    => new ReflectionClass(SchemaLoaderTestMockException4::class),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderConstructException
     *
     * @param mixed $expected
     * @param \ReflectionClass $input
     */
    public function testConstructException($expected, $input)
    {
        $this->expectException($expected);
        new SchemaLoader($input);
    }
}

#[Schema(Schema::TYPE_ROOT)]
class SchemaLoaderTestMockRootObject
{
}

#[Schema(Schema::TYPE_INNER)]
class SchemaLoaderTestMockInnerObject
{
}

class SchemaLoaderTestMockObject
{
}

#[Schema(Schema::TYPE_ROOT), Schema(Schema::TYPE_INNER)]
class SchemaLoaderTestMockException2
{
}

#[Schema(Schema::TYPE_ROOT), Schema(Schema::TYPE_ROOT)]
class SchemaLoaderTestMockException3
{
}

#[Schema(Schema::TYPE_INNER), Schema(Schema::TYPE_INNER)]
class SchemaLoaderTestMockException4
{
}
