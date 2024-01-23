<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Data;

use PHPUnit\Framework\TestCase;
use Selen\Data\ArrayPath;

/**
 * @coversDefaultClass \Selen\Data\ArrayPath
 *
 * @see ArrayPath
 *
 * @internal
 */
class ArrayPathTest extends TestCase
{
    public function testConstruct1(): void
    {
        $this->assertInstanceOf(ArrayPath::class, new ArrayPath());
    }

    public function testDown(): void
    {
        $instance = new ArrayPath();

        // verify default state
        $this->assertSame(0, $instance->getCurrentIndex());
        $this->assertSame([], $instance->getPaths());

        // verify action
        $this->assertSame(true, $instance->down());
        // verify state
        $this->assertSame(1, $instance->getCurrentIndex());
        $this->assertSame([1 => ''], $instance->getPaths());

        // verify action
        $this->assertSame(true, $instance->down());
        // verify state
        $this->assertSame(2, $instance->getCurrentIndex());
        $this->assertSame([1 => '', 2 => ''], $instance->getPaths());

        // verify action
        $this->assertSame(true, $instance->down());
        // verify state
        $this->assertSame(3, $instance->getCurrentIndex());
        $this->assertSame([1 => '', 2 => '', 3 => ''], $instance->getPaths());
    }

    public function testUp(): void
    {
        $instance = new ArrayPath();

        // verify default state
        $this->assertSame(0, $instance->getCurrentIndex());
        $this->assertSame([], $instance->getPaths());

        // verify action
        $this->assertSame(false, $instance->up());
        // verify state
        $this->assertSame(0, $instance->getCurrentIndex());
        $this->assertSame([], $instance->getPaths());

        $instance->down();
        $instance->down();
        $instance->down();
        // verify state
        $this->assertSame(3, $instance->getCurrentIndex());
        $this->assertSame([1 => '', 2 => '', 3 => ''], $instance->getPaths());

        // verify action
        $this->assertSame(true, $instance->up());
        // verify state
        $this->assertSame(2, $instance->getCurrentIndex());
        $this->assertSame([1 => '', 2 => ''], $instance->getPaths());

        // verify action
        $this->assertSame(true, $instance->up());
        // verify state
        $this->assertSame(1, $instance->getCurrentIndex());
        $this->assertSame([1 => ''], $instance->getPaths());
    }

    public function testSetCurrentPath(): void
    {
        $instance = new ArrayPath();

        // action
        $this->assertFalse($instance->setCurrentPath('key1'));
        // verify default state
        $this->assertSame(0, $instance->getCurrentIndex());
        $this->assertSame([], $instance->getPaths());

        // verify action
        $instance->down();
        $this->assertTrue($instance->setCurrentPath('key1'));
        // verify state
        $this->assertSame(1, $instance->getCurrentIndex());
        $this->assertSame([1 => 'key1'], $instance->getPaths());

        // verify action
        $instance->down();
        $this->assertTrue($instance->setCurrentPath('key2'));
        // verify state
        $this->assertSame(2, $instance->getCurrentIndex());
        $this->assertSame([1 => 'key1', 2 => 'key2'], $instance->getPaths());

        // verify action
        $this->assertTrue($instance->setCurrentPath('renameKey2'));
        // verify state
        $this->assertSame(2, $instance->getCurrentIndex());
        $this->assertSame([1 => 'key1', 2 => 'renameKey2'], $instance->getPaths());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderToString(): array
    {
        return [
            'pattern001' => ['expected' => '',                         'input' => []],
            'pattern002' => ['expected' => '',                         'input' => ['']],
            'pattern003' => ['expected' => 'depth1',                   'input' => ['depth1']],
            'pattern004' => ['expected' => 'depth1.depth2',            'input' => ['depth1', 'depth2']],
            'pattern005' => ['expected' => 'depth1.depth2.[0].depth3', 'input' => ['depth1', 'depth2', '[0]', 'depth3']],
        ];
    }

    /**
     * @dataProvider dataProviderToString
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToString($expected, $input): void
    {
        $this->assertSame($expected, ArrayPath::toString($input));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderToArray(): array
    {
        return [
            'pattern001' => ['expected' => [],                                    'input' => ''],
            'pattern002' => ['expected' => ['depth1'],                            'input' => 'depth1'],
            'pattern003' => ['expected' => ['depth1', 'depth2'],                  'input' => 'depth1.depth2'],
            'pattern004' => ['expected' => ['depth1', 'depth2', '[0]', 'depth3'], 'input' => 'depth1.depth2.[0].depth3'],
        ];
    }

    /**
     * @dataProvider dataProviderToArray
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testToArray($expected, $input): void
    {
        $this->assertSame($expected, ArrayPath::toArray($input));
    }
}
