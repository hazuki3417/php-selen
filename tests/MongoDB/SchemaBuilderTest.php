<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema;
use Selen\MongoDB\Builder\InsertSchema;
use Selen\MongoDB\Builder\UpdateSchema;
use Selen\MongoDB\SchemaBuilder;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\SchemaBuilder
 *
 * @see SchemaBuilder
 *
 * @internal
 */
class SchemaBuilderTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new SchemaBuilder(SchemaBuilderTestMockRootObject::class);
        $this->assertInstanceOf(SchemaBuilder::class, $instance);

        $this->assertSame(SchemaBuilderTestMockRootObject::class, $instance->schemaClassName);
        $this->assertInstanceOf(InsertSchema::class, $instance->insert);
        $this->assertInstanceOf(UpdateSchema::class, $instance->update);
    }
}

#[Schema('root')]
class SchemaBuilderTestMockRootObject
{
}
