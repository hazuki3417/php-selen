<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Validate\Type;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Validate\Type
 *
 * @group Selen/MongoDB/Attributes/Validate/Type
 *
 * @see \Selen\MongoDB\Attributes\Validate\Type
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Validate/Type
 *
 * @internal
 */
class TypeTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Type();

        $this->assertInstanceOf(Type::class, $instance);
    }
}
