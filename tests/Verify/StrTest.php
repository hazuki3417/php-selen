<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Verify\Str;

use PHPUnit\Framework\TestCase;
use Selen\Verify\Str;
use Selen\Verify\Str\Length;
use Selen\Verify\Str\Space;
use Selen\Verify\Str\Width;

/**
 * @coversDefaultClass \Selen\Verify\Str
 *
 * @group Selen/Verify/Str
 *
 * @see \Selen\Verify\Str
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Verify/Str
 *
 * @internal
 */
class StrTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Str::class, Str::set(''));
    }

    public function testLength()
    {
        $this->assertInstanceOf(Length::class, Str::set('')->length());
    }

    public function testSpace()
    {
        $this->assertInstanceOf(Space::class, Str::set('')->space());
    }

    public function testWidth()
    {
        $this->assertInstanceOf(Width::class, Str::set('')->width());
    }

    public function testRadix()
    {
        $this->assertTrue(Str::set('0')->radix(2));
    }
}
