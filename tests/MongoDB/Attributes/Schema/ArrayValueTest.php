<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes\Schema\ArrayValue\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema\ArrayValue;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Schema\ArrayValue
 *
 * @group Selen/MongoDB/Attributes/Schema/ArrayValue
 *
 * @see \Selen\MongoDB\Attributes\Schema\ArrayValue
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Schema/ArrayValue
 *
 * @internal
 */
class ArrayValueTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new ArrayValue();

        $this->assertInstanceOf(ArrayValue::class, $instance);
    }
}
