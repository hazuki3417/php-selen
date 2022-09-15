<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes\Schema\Document\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema\Document;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Schema\Document
 *
 * @group Selen/MongoDB/Attributes/Schema/Document
 *
 * @see \Selen\MongoDB\Attributes\Schema\Document
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Schema/Document
 *
 * @internal
 */
class DocumentTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Document();

        $this->assertInstanceOf(Document::class, $instance);
    }
}
