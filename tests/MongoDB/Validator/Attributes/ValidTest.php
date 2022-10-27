<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Validator\Attributes\Valid;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Validator\Attributes\Valid;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Validator\Attributes\Valid
 *
 * @group Selen/MongoDB/Validator/Attributes/Valid
 *
 * @see \Selen\MongoDB\Validator\Attributes\Valid
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Validator/Attributes/Valid
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
