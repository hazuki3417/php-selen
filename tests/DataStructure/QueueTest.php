<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\DataStructure\Test;

use PHPUnit\Framework\TestCase;
use Selen\DataStructure\Queue;

/**
 * @coversDefaultClass \Selen\DataStructure\Queue
 *
 * @group Selen/DataStructure
 * @group Selen/DataStructure/Queue
 *
 * @see \Selen\DataStructure\Queue
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/DataStructure/Queue
 *
 * @internal
 */
class QueueTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Queue('string');

        $this->assertInstanceOf(Queue::class, $instance);
    }

    public function testEnqueue()
    {
        $instance = new Queue(\DateTime::class);

        $addData1 = new \DateTime();
        $addData2 = new \DateTime('-7 days');

        $this->assertTrue($instance->isEmpty());

        $instance->enqueue($addData1);
        $instance->enqueue($addData2);

        $this->assertTrue($instance->isNotEmpty());
    }

    public function testEnqueueException()
    {
        $instance = new Queue(\DateTime::class);

        $addData1 = new \DateTime();
        $addData2 = $addData1->format('Y-m-d');

        $instance->enqueue($addData1);

        $this->expectException(\InvalidArgumentException::class);

        $instance->enqueue($addData2);
    }

    public function testDequeue()
    {
        $instance = new Queue(\DateTime::class);

        $this->assertEquals(null, $instance->dequeue());

        $addData1 = new \DateTime();
        $addData2 = new \DateTime('-7 days');

        $instance->enqueue($addData1);
        $instance->enqueue($addData2);

        $this->assertEquals($addData1, $instance->dequeue());
        $this->assertEquals($addData2, $instance->dequeue());
        $this->assertEquals(null, $instance->dequeue());
    }

    public function testIsEmpty()
    {
        $instance = new Queue('string');

        $this->assertTrue($instance->isEmpty());

        $instance->enqueue('add data1');

        $this->assertFalse($instance->isEmpty());

        $instance->enqueue('add data2');

        $this->assertFalse($instance->isEmpty());

        $instance->dequeue();

        $this->assertFalse($instance->isEmpty());

        $instance->dequeue();

        $this->assertTrue($instance->isEmpty());
    }

    public function testIsNotEmpty()
    {
        $instance = new Queue('string');

        $this->assertFalse($instance->isNotEmpty());

        $instance->enqueue('add data1');

        $this->assertTrue($instance->isNotEmpty());

        $instance->enqueue('add data2');

        $this->assertTrue($instance->isNotEmpty());

        $instance->dequeue();

        $this->assertTrue($instance->isNotEmpty());

        $instance->dequeue();

        $this->assertFalse($instance->isNotEmpty());
    }

    public function testSize()
    {
        $instance = new Queue('string');

        $this->assertEquals(0, $instance->size());

        $instance->enqueue('add data1');

        $this->assertEquals(1, $instance->size());

        $instance->enqueue('add data2');

        $this->assertEquals(2, $instance->size());

        $instance->dequeue();

        $this->assertEquals(1, $instance->size());

        $instance->dequeue();

        $this->assertEquals(0, $instance->size());
    }

    public function testClear()
    {
        $instance = new Queue('string');

        $this->assertTrue($instance->isEmpty());

        $instance->enqueue('add data1');

        $this->assertTrue($instance->isNotEmpty());

        $instance->clear();

        $this->assertTrue($instance->isEmpty());

        $instance->enqueue('add data1');
        $instance->enqueue('add data2');

        $this->assertTrue($instance->isNotEmpty());

        $instance->clear();

        $this->assertTrue($instance->isEmpty());
    }

    public function testForeach()
    {
        $queue = new Queue('string');

        $objects = ['aaaaa', 'bbbbb', 'ccccc', 'ddddd', 'eeeee', 'fffff'];

        foreach ($objects as $object) {
            $queue->enqueue($object);
        }

        foreach ($queue as $key => $queueData) {
            $this->assertEquals($objects[$key], $queueData);
        }

        $this->assertTrue($queue->isEmpty());
    }
}
