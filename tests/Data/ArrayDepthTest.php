<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Test;

use PHPUnit\Framework\TestCase;
use Selen\Data\ArrayDepth;

/**
 * @coversDefaultClass \Selen\Data\ArrayDepth
 *
 * @group Selen/Data
 * @group Selen/Data/ArrayDepth
 *
 * @see \Selen\Data\ArrayDepth
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Data/ArrayDepth
 *
 * @internal
 */
class ArrayDepthTest extends TestCase
{
    public function testConstruct1()
    {
        $this->assertInstanceOf(ArrayDepth::class, new ArrayDepth());
    }

    public function testClassLogic()
    {
        $instance = new ArrayDepth();

        $this->assertEquals(0, $instance->current());

        $this->assertEquals(false, $instance->up());
        $this->assertEquals(0, $instance->current());

        $this->assertEquals(true, $instance->down());
        $this->assertEquals(1, $instance->current());

        $this->assertEquals(true, $instance->up());
        $this->assertEquals(0, $instance->current());

        $this->assertEquals(true, $instance->down());
        $this->assertEquals(1, $instance->current());

        $this->assertEquals(true, $instance->down());
        $this->assertEquals(2, $instance->current());

        $this->assertEquals(true, $instance->down());
        $this->assertEquals(3, $instance->current());

        $this->assertEquals(true, $instance->up());
        $this->assertEquals(2, $instance->current());
    }
}
