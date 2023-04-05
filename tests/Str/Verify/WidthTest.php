<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Verify\Str;

use PHPUnit\Framework\TestCase;
use Selen\Str\Verify\Width;
use Selen\Str\Verify\Width\Full;
use Selen\Str\Verify\Width\Half;

/**
 * @coversDefaultClass \Selen\Str\Verify\Width
 *
 * @see \Selen\Str\Verify\Width
 *
 * @internal
 */
class WidthTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Width::class, Width::set(''));
    }

    public function testFull()
    {
        $this->assertInstanceOf(Full::class, Width::set('')->full());
    }

    public function testHalf()
    {
        $this->assertInstanceOf(Half::class, Width::set('')->half());
    }
}
