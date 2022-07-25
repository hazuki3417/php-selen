<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\DataStructure\Test;

use PHPUnit\Framework\TestCase;
use Selen\DataStructure\Stack;

/**
 * @coversDefaultClass \Selen\DataStructure\Stack
 *
 * @group Selen/DataStructure
 * @group Selen/DataStructure/Stack
 *
 * @see \Selen\DataStructure\Stack
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/DataStructure/Stack
 *
 * @internal
 */
class StackTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Stack('string');

        $this->assertInstanceOf(Stack::class, $instance);
    }

    public function testPush()
    {
        $instance = new Stack(\DateTime::class);

        $addData1 = new \DateTime();
        $addData2 = new \DateTime('-7 days');

        $this->assertTrue($instance->isEmpty());

        $instance->push($addData1);
        $instance->push($addData2);

        $this->assertTrue($instance->isNotEmpty());
    }

    public function testPushException()
    {
        $instance = new Stack(\DateTime::class);

        $addData1 = new \DateTime();
        $addData2 = $addData1->format('Y-m-d');

        $instance->push($addData1);

        $this->expectException(\InvalidArgumentException::class);

        $instance->push($addData2);
    }

    public function testPop()
    {
        $instance = new Stack(\DateTime::class);

        $this->assertEquals(null, $instance->pop());

        $addData1 = new \DateTime();
        $addData2 = new \DateTime('-7 days');

        $instance->push($addData1);
        $instance->push($addData2);

        $this->assertEquals($addData2, $instance->pop());
        $this->assertEquals($addData1, $instance->pop());
        $this->assertEquals(null, $instance->pop());
    }

    public function testIsEmpty()
    {
        $instance = new Stack('string');

        $this->assertTrue($instance->isEmpty());

        $instance->push('add data1');

        $this->assertFalse($instance->isEmpty());

        $instance->push('add data2');

        $this->assertFalse($instance->isEmpty());

        $instance->pop();

        $this->assertFalse($instance->isEmpty());

        $instance->pop();

        $this->assertTrue($instance->isEmpty());
    }

    public function testIsNotEmpty()
    {
        $instance = new Stack('string');

        $this->assertFalse($instance->isNotEmpty());

        $instance->push('add data1');

        $this->assertTrue($instance->isNotEmpty());

        $instance->push('add data2');

        $this->assertTrue($instance->isNotEmpty());

        $instance->pop();

        $this->assertTrue($instance->isNotEmpty());

        $instance->pop();

        $this->assertFalse($instance->isNotEmpty());
    }

    public function testSize()
    {
        $instance = new Stack('string');

        $this->assertEquals(0, $instance->size());

        $instance->push('add data1');

        $this->assertEquals(1, $instance->size());

        $instance->push('add data2');

        $this->assertEquals(2, $instance->size());

        $instance->pop();

        $this->assertEquals(1, $instance->size());

        $instance->pop();

        $this->assertEquals(0, $instance->size());
    }

    public function testClear()
    {
        $instance = new Stack('string');

        $this->assertTrue($instance->isEmpty());

        $instance->push('add data1');

        $this->assertTrue($instance->isNotEmpty());

        $instance->clear();

        $this->assertTrue($instance->isEmpty());

        $instance->push('add data1');
        $instance->push('add data2');

        $this->assertTrue($instance->isNotEmpty());

        $instance->clear();

        $this->assertTrue($instance->isEmpty());
    }

    public function testForeach()
    {
        $stack = new Stack('string');

        $objects = ['aaaaa', 'bbbbb', 'ccccc', 'ddddd', 'eeeee', 'fffff'];

        foreach ($objects as $object) {
            $stack->push($object);
        }

        foreach ($stack as $key => $stackData) {
            $this->assertEquals($objects[$key], $stackData);
        }

        $this->assertTrue($stack->isEmpty());
    }
}
