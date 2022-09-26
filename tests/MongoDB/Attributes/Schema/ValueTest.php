<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes\Schema\Valid\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema\Valid;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Schema\Valid
 *
 * @group Selen/MongoDB/Attributes/Schema/Valid
 *
 * @see \Selen\MongoDB\Attributes\Schema\Valid
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Schema/Valid
 *
 * @internal
 */
class ValidTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Valid();

        $this->assertInstanceOf(Valid::class, $instance);
    }
}
