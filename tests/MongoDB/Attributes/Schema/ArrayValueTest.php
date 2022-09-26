<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes\Schema\ArrayValid\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema\ArrayValid;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Schema\ArrayValid
 *
 * @group Selen/MongoDB/Attributes/Schema/ArrayValid
 *
 * @see \Selen\MongoDB\Attributes\Schema\ArrayValid
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Schema/ArrayValid
 *
 * @internal
 */
class ArrayValidTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new ArrayValid();

        $this->assertInstanceOf(ArrayValid::class, $instance);
    }
}
