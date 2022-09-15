<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema\Value;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Schema\Value
 *
 * @group Selen/MongoDB/Attributes/Schema/Value
 *
 * @see \Selen\MongoDB\Attributes\Schema\Value
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Schema/Value
 *
 * @internal
 */
class ValueTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Value();

        $this->assertInstanceOf(Value::class, $instance);
    }
}
