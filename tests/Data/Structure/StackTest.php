<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure\Test;

use PHPUnit\Framework\TestCase;
use Selen\Data\Structure\Stack;

/**
 * @coversDefaultClass \Selen\Data\Structure\Stack
 *
 * @group Selen/Data
 * @group Selen/Data/Structure
 * @group Selen/Data/Structure/Stack
 *
 * @see \Selen\Data\Structure\Stack
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Data/Structure/Stack
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

        $this->assertSame(null, $instance->pop());

        $addData1 = new \DateTime();
        $addData2 = new \DateTime('-7 days');

        $instance->push($addData1);
        $instance->push($addData2);

        $this->assertSame($addData2, $instance->pop());
        $this->assertSame($addData1, $instance->pop());
        $this->assertSame(null, $instance->pop());
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

        $this->assertSame(0, $instance->size());

        $instance->push('add data1');

        $this->assertSame(1, $instance->size());

        $instance->push('add data2');

        $this->assertSame(2, $instance->size());

        $instance->pop();

        $this->assertSame(1, $instance->size());

        $instance->pop();

        $this->assertSame(0, $instance->size());
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

    public function testToArray()
    {
        $instance = new Stack('string');
        $this->assertIsArray($instance->toArray());
    }

    public function testForeach()
    {
        $stack = new Stack('string');

        $objects = ['aaaaa', 'bbbbb', 'ccccc', 'ddddd', 'eeeee', 'fffff'];

        foreach ($objects as $object) {
            $stack->push($object);
        }

        foreach ($stack as $key => $stackData) {
            $this->assertSame($objects[$key], $stackData);
        }

        $this->assertTrue($stack->isEmpty());
    }
}
