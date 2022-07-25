<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str\Test;

use PHPUnit\Framework\TestCase;
use Selen\Verify\Str\Width;
use Selen\Verify\Str\Width\Full;
use Selen\Verify\Str\Width\Half;

/**
 * @coversDefaultClass \Selen\Verify\Str\Width
 *
 * @group Selen/Verify/Str
 * @group Selen/Verify/Str/Width
 *
 * @see \Selen\Verify\Str\Width
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Verify/Str/Width/Width
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
