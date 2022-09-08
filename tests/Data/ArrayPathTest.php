<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Test;

use PHPUnit\Framework\TestCase;
use Selen\Data\ArrayPath;

/**
 * @coversDefaultClass \Selen\Data\ArrayPath
 *
 * @group Selen
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

    public function testUpDownCurrent()
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

    public function testSet()
    {
        $instance = new ArrayPath();

        $this->assertNull($instance->set('path1'));
    }

    public function testFetch()
    {
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

    public function testFetchException1()
    {
        $instance = new ArrayPath();

        $this->expectException(\ValueError::class);
        $instance->fetch(-1, 0);
    }

    public function testFetchException2()
    {
        $instance = new ArrayPath();

        $this->expectException(\ValueError::class);
        $instance->fetch(0, 3);
    }

    public function testFetchException3()
    {
        $instance = new ArrayPath();
        $instance->set('path0');

        $instance->down();
        $instance->set('path1');

        $instance->down();

        $this->expectException(\ValueError::class);
        $instance->fetch(1, 0);
    }

    public function dataProviderToString()
    {
        return [
            'pattern001' => ['expected' => '',                         'input' => []],
            'pattern002' => ['expected' => '',                         'input' => ['']],
            'pattern003' => ['expected' => 'depth1',                   'input' => ['depth1']],
            'pattern004' => ['expected' => 'depth1.depth2',            'input' => ['depth1', 'depth2']],
            'pattern005' => ['expected' => 'depth1.depth2.[0].depth3', 'input' => ['depth1', 'depth2', '[0]', 'depth3']],
        ];
    }

    /**
     * @dataProvider dataProviderToString
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToString($expected, $input)
    {
        $this->assertSame($expected, ArrayPath::toString($input));
    }

    public function dataProviderToArray()
    {
        return [
            'pattern001' => ['expected' => [],                                    'input' => ''],
            'pattern002' => ['expected' => ['depth1'],                            'input' => 'depth1'],
            'pattern003' => ['expected' => ['depth1', 'depth2'],                  'input' => 'depth1.depth2'],
            'pattern004' => ['expected' => ['depth1', 'depth2', '[0]', 'depth3'], 'input' => 'depth1.depth2.[0].depth3'],
        ];
    }

    /**
     * @dataProvider dataProviderToArray
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToArray($expected, $input)
    {
        $this->assertSame($expected, ArrayPath::toArray($input));
    }
}
