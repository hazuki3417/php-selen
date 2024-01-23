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
use Selen\MongoDB\SchemaValidator;
use Selen\MongoDB\Validator\InsertSchema;
use Selen\MongoDB\Validator\UpdateSchema;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\SchemaValidator
 *
 * @see SchemaValidator
 *
 * @internal
 */
class SchemaValidatorTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new SchemaValidator(SchemaValidatorTestMockRootObject::class);
        $this->assertInstanceOf(SchemaValidator::class, $instance);

        $this->assertSame(SchemaValidatorTestMockRootObject::class, $instance->schemaClassName);
        $this->assertInstanceOf(InsertSchema::class, $instance->insert);
        $this->assertInstanceOf(UpdateSchema::class, $instance->update);
    }
}

#[Schema('root')]
class SchemaValidatorTestMockRootObject
{
}
