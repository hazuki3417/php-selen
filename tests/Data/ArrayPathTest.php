<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Test;

use phpDocumentor\Reflection\Types\Array_;
use PHPUnit\Framework\TestCase;
use Selen\Data\ArrayPath;

/**
 * @coversDefaultClass \Selen\Data\ArrayPath
 *
 * @group Selen/Data
 * @group Selen/Data/ArrayPath
 *
 * @see \Selen\Data\ArrayPath
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Data/ArrayPath
 *
 * @internal
 */
class ArrayPathTest extends TestCase
{
    public function testConstruct1()
    {
        $this->assertInstanceOf(ArrayPath::class, new ArrayPath());
    }

    public function testClassLogic()
    {
        $instance = new ArrayPath();

        $this->assertSame(0, $instance->current());

        $this->assertSame(false, $instance->up());
        $this->assertSame(0, $instance->current());

        $this->assertSame(true, $instance->down());
        $this->assertSame(1, $instance->current());

        $this->assertSame(true, $instance->up());
        $this->assertSame(0, $instance->current());

        $this->assertSame(true, $instance->down());
        $this->assertSame(1, $instance->current());

        $this->assertSame(true, $instance->down());
        $this->assertSame(2, $instance->current());

        $this->assertSame(true, $instance->down());
        $this->assertSame(3, $instance->current());

        $this->assertSame(true, $instance->up());
        $this->assertSame(2, $instance->current());
    }

    public function testSet(){
        $instance = new ArrayPath();

        $this->assertNull($instance->set("path1"));
    }

    public function testFetch(){
        $instance = new ArrayPath();
        $instance->set('path0');

        $instance->down();
        $instance->set('path1');

        $instance->down();
        $instance->set('path2');

        $instance->down();

        $this->assertSame(['path0'], $instance->fetch(0, 0));
        $this->assertSame(['path0', 'path1'], $instance->fetch(0, 1));
        $this->assertSame(['path0', 'path1', 'path2'], $instance->fetch(0, 2));
        $this->assertSame(['path1'], $instance->fetch(1, 1));
        $this->assertSame(['path1', 'path2'], $instance->fetch(1, 2));
        $this->assertSame(['path0', 'path1', 'path2', ''], $instance->fetch(0, $instance->current()));

        $instance->up();
        $instance->up();
        $instance->up();

        $this->assertSame(['path0'], $instance->fetch(0, 0));
        $this->assertSame(['path0', 'path1'], $instance->fetch(0, 1));
        $this->assertSame(['path0', 'path1', 'path2'], $instance->fetch(0, 2));
        $this->assertSame(['path1'], $instance->fetch(1, 1));
        $this->assertSame(['path1', 'path2'], $instance->fetch(1, 2));
        $this->assertSame(['path0'], $instance->fetch(0, $instance->current()));
    }

    public function testFetchException1(){
        $instance = new ArrayPath();

        $this->expectException(\ValueError::class);
        $instance->fetch(-1, 0);
    }

    public function testFetchException2(){
        $instance = new ArrayPath();

        $this->expectException(\ValueError::class);
        $instance->fetch(0, 3);
    }

    public function testFetchException3(){
        $instance = new ArrayPath();
        $instance->set('path0');

        $instance->down();
        $instance->set('path1');

        $instance->down();

        $this->expectException(\ValueError::class);
        $instance->fetch(1, 0);
    }


    public function testToString(){
        $instance = new ArrayPath();
        $instance->set('path0');

        $instance->down();
        $instance->set('path1');

        $instance->down();
        $instance->set('path2');

        $instance->down();
        $instance->set('path3');

        $expected = 'path0.path1.path2.path3';
        $this->assertSame(
            $expected,
            ArrayPath::toString($instance->fetch(0, $instance->current()))
        );
    }
}
