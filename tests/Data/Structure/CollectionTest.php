<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure\Test;

use PHPUnit\Framework\TestCase;
use Selen\Data\Structure\Collection;

/**
 * @coversDefaultClass \Selen\Data\Structure\Collection
 *
 * @group Selen/Data
 * @group Selen/Data/Structure
 * @group Selen/Data/Structure/Collection
 *
 * @see \Selen\Data\Structure\Collection
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Data/Structure/Collection
 *
 * @internal
 */
class CollectionTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Collection('string');

        $this->assertInstanceOf(Collection::class, $instance);
    }

    public function testAdd()
    {
        $instance = new Collection(\DateTime::class);

        $addData1 = new \DateTime();
        $addData2 = new \DateTime('-7 days');

        $this->assertEquals(0, $instance->size());

        $instance->add($addData1);
        $this->assertEquals(1, $instance->size());

        $instance->add($addData2);
        $this->assertEquals(2, $instance->size());
    }

    public function testAddException()
    {
        $instance = new Collection(\DateTime::class);

        $addData1 = new \DateTime();
        $addData2 = $addData1->format('Y-m-d');

        $instance->add($addData1);

        $this->expectException(\InvalidArgumentException::class);

        $instance->add($addData2);
    }

    public function testRemove()
    {
        $instance = new Collection(\DateTime::class);

        $removeData1 = new \DateTime();
        $removeData2 = new \DateTime('-7 days');

        $this->assertEquals(0, $instance->size());

        $this->assertTrue($instance->add($removeData1));
        $this->assertEquals(1, $instance->size());

        $this->assertTrue($instance->add($removeData2));
        $this->assertEquals(2, $instance->size());

        $this->assertTrue($instance->remove($removeData1));
        $this->assertEquals(1, $instance->size());

        $this->assertTrue($instance->remove($removeData2));
        $this->assertEquals(0, $instance->size());
    }

    public function testRemoveException()
    {
        $instance = new Collection(\DateTime::class);

        $removeData1 = new \DateTime();
        $removeData2 = $removeData1->format('Y-m-d');

        $instance->remove($removeData1);

        $this->expectException(\InvalidArgumentException::class);

        $instance->remove($removeData2);
    }

    public function testIsEmpty()
    {
        $instance = new Collection(\DateTime::class);

        $targetData1 = new \DateTime();
        $targetData2 = new \DateTime('-7 days');

        $this->assertTrue($instance->isEmpty());

        $instance->add($targetData1);

        $this->assertFalse($instance->isEmpty());

        $instance->add($targetData2);

        $this->assertFalse($instance->isEmpty());

        $instance->remove($targetData1);

        $this->assertFalse($instance->isEmpty());

        $instance->remove($targetData2);

        $this->assertTrue($instance->isEmpty());
    }

    public function testIsNotEmpty()
    {
        $instance = new Collection(\DateTime::class);

        $targetData1 = new \DateTime();
        $targetData2 = new \DateTime('-7 days');

        $this->assertFalse($instance->isNotEmpty());

        $instance->add($targetData1);

        $this->assertTrue($instance->isNotEmpty());

        $instance->add($targetData2);

        $this->assertTrue($instance->isNotEmpty());

        $instance->remove($targetData1);

        $this->assertTrue($instance->isNotEmpty());

        $instance->remove($targetData2);

        $this->assertFalse($instance->isNotEmpty());
    }

    public function testSize()
    {
        $instance = new Collection(\DateTime::class);

        $targetData1 = new \DateTime();
        $targetData2 = new \DateTime('-7 days');

        $this->assertEquals(0, $instance->size());

        $instance->add($targetData1);

        $this->assertEquals(1, $instance->size());

        $instance->add($targetData2);

        $this->assertEquals(2, $instance->size());

        $instance->remove($targetData1);

        $this->assertEquals(1, $instance->size());

        $instance->remove($targetData2);

        $this->assertEquals(0, $instance->size());
    }

    public function testClear()
    {
        $instance = new Collection(\DateTime::class);

        $targetData1 = new \DateTime();
        $targetData2 = new \DateTime('-7 days');

        $this->assertTrue($instance->isEmpty());

        $instance->add($targetData1);

        $this->assertTrue($instance->isNotEmpty());

        $instance->clear();

        $this->assertTrue($instance->isEmpty());

        $instance->add($targetData1);
        $instance->add($targetData2);

        $this->assertTrue($instance->isNotEmpty());

        $instance->clear();

        $this->assertTrue($instance->isEmpty());
    }
}
