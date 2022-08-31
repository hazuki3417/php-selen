<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Exchange\Define\Key\Test;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Exchange\Define\Key;

/**
 * @coversDefaultClass \Selen\Schema\Exchange\Define\Key
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Exchange
 * @group Selen/Schema/Exchange/Define
 * @group Selen/Schema/Exchange/Define/Key
 *
 * @see \Selen\Schema\Exchange\Define\Key
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Exchange/Define/Key
 *
 * @internal
 */
class KeyTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Key::class, new Key('keyName'));
        $this->assertInstanceOf(Key::class, new Key(0));
        $this->assertInstanceOf(Key::class, new Key(null));
    }

    public function testConstructException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Key(false);
    }

    public function dataProviderName()
    {
        return [
            'pattern001' => ['expected' => 'keyName',  'input' => 'keyName'],
            'pattern002' => ['expected' => '0',        'input' => '0'],
            'pattern003' => ['expected' => 0,          'input' => 0],
            'pattern004' => ['expected' => null,       'input' => null],
        ];
    }

    /**
     * @dataProvider dataProviderName
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testName($expected, $input)
    {
        $this->assertSame($expected, (new Key($input))->name());
    }
}
