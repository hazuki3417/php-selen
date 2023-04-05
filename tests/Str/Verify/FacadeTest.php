<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Str\Verify;

use PHPUnit\Framework\TestCase;
use Selen\Str\Verify\Facade;
use Selen\Str\Verify\Length;
use Selen\Str\Verify\Space;
use Selen\Str\Verify\Width;

/**
 * @coversDefaultClass \Selen\Str\Verify\Facade
 *
 * @see \Selen\Str\Verify\Facade
 *
 * @internal
 */
class FacadeTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Facade::class, Facade::set(''));
    }

    public function testLength()
    {
        $this->assertInstanceOf(Length::class, Facade::set('')->length());
    }

    public function testSpace()
    {
        $this->assertInstanceOf(Space::class, Facade::set('')->space());
    }

    public function testWidth()
    {
        $this->assertInstanceOf(Width::class, Facade::set('')->width());
    }
}
