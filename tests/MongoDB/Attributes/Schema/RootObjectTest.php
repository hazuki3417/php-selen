<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes\Schema\RootObject\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema\RootObject;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Schema\RootObject
 *
 * @group Selen/MongoDB/Attributes/Schema/RootObject
 *
 * @see \Selen\MongoDB\Attributes\Schema\RootObject
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Schema/RootObject
 *
 * @internal
 */
class RootObjectTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new RootObject();

        $this->assertInstanceOf(RootObject::class, $instance);
    }
}
