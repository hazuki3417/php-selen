<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\DataStructure\Test;

use PHPUnit\Framework\TestCase;
use Selen\DataStructure\Objects;

/**
 * @coversDefaultClass \Selen\DataStructure\Objects
 *
 * @group Selen/DataStructure
 * @group Selen/DataStructure/Objects
 *
 * @see \Selen\DataStructure\Objects
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/DataStructure/Objects
 *
 * @internal
 */
class ObjectsTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Objects([1, 2, 3]);

        $this->assertInstanceOf(Objects::class, $instance);
    }

    public function testIsEmpty()
    {
        $instance = new Objects([]);

        $this->assertTrue($instance->isEmpty());

        $instance = new Objects([1]);

        $this->assertFalse($instance->isEmpty());
    }

    public function testIsNotEmpty()
    {
        $instance = new Objects([]);

        $this->assertFalse($instance->isNotEmpty());

        $instance = new Objects([1]);

        $this->assertTrue($instance->isNotEmpty());

        $instance = new Objects([1, 2]);

        $this->assertTrue($instance->isNotEmpty());
    }

    public function testSize()
    {
        $instance = new Objects([]);

        $this->assertEquals(0, $instance->size());

        $instance = new Objects([1]);

        $this->assertEquals(1, $instance->size());

        $instance = new Objects([1, 2]);

        $this->assertEquals(2, $instance->size());
    }

    public function testClear()
    {
        $instance = new Objects([]);

        $this->assertTrue($instance->isEmpty());
        $this->assertNull($instance->clear());
        $this->assertTrue($instance->isEmpty());

        $instance = new Objects([1, 2]);

        $this->assertTrue($instance->isNotEmpty());
        $this->assertNull($instance->clear());
        $this->assertTrue($instance->isEmpty());
    }
}
