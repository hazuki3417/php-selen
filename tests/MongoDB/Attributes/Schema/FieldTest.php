<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Str\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema\Field;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Schema\Field
 *
 * @group Selen/MongoDB/Attributes/Schema/Field
 *
 * @see \Selen\MongoDB\Attributes\Schema\Field
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Schema/Field
 *
 * @internal
 */
class FieldTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Field();

        $this->assertInstanceOf(Field::class, $instance);
    }
}
