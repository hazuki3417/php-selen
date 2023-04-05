<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Data;

use PHPUnit\Framework\TestCase;
use Selen\Data\ArrayDepth;

/**
 * @coversDefaultClass \Selen\Data\ArrayDepth
 *
 * @see \Selen\Data\ArrayDepth
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
}
