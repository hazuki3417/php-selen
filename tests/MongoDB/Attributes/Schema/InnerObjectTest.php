<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Attributes\Schema\InnerObject;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema\InnerObject;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Schema\InnerObject
 *
 * @group Selen/MongoDB/Attributes/Schema/InnerObject
 *
 * @see \Selen\MongoDB\Attributes\Schema\InnerObject
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Schema/InnerObject
 *
 * @internal
 */
class InnerObjectTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new InnerObject();

        $this->assertInstanceOf(InnerObject::class, $instance);
    }
}
