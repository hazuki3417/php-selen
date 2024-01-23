<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Exchange\Define;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Exchange\Define\Key;
use TypeError;

/**
 * @coversDefaultClass \Selen\Schema\Exchange\Define\Key
 *
 * @see Key
 *
 * @internal
 */
class KeyTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(Key::class, new Key('keyName'));
        $this->assertInstanceOf(Key::class, new Key(0));
        $this->assertInstanceOf(Key::class, new Key(null));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderGetName(): array
    {
        return [
            'pattern001' => ['expected' => 'keyName',  'input' => 'keyName'],
            'pattern002' => ['expected' => '0',        'input' => '0'],
            'pattern003' => ['expected' => 0,          'input' => 0],
            'pattern004' => ['expected' => null,       'input' => null],
        ];
    }

    /**
     * @dataProvider dataProviderGetName
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetName($expected, $input): void
    {
        $this->assertSame($expected, (new Key($input))->getName());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderSetName(): array
    {
        return [
            'pattern001' => [
                'expected' => [
                    'exception' => null,
                ],
                'input' => 'keyName',
            ],
            'pattern002' => [
                'expected' => [
                    'exception' => null,
                ],
                'input' => '0',
            ],
            'pattern003' => [
                'expected' => [
                    'exception' => null,
                ],
                'input' => 0,
            ],
            'pattern004' => [
                'expected' => [
                    'exception' => null,
                ],
                'input' => null,
            ],
            'pattern005' => [
                'expected' => [
                    'exception' => TypeError::class,
                ],
                'input' => [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderSetName
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testSetName($expected, $input): void
    {
        $key = new Key(null);

        [
            'exception' => $expectedException,
        ] = $expected;

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }
        $key->setName($input);
        $this->assertTrue(true);
    }

    public function testEnableAdd(): void
    {
        $this->assertInstanceOf(Key::class, (new Key('keyName'))->enableAdd());
    }

    public function testEnableAddException1(): void
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableAdd()->enableRemove();
    }

    public function testEnableAddException2(): void
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableAdd()->enableRename();
    }

    public function testEnableRemove(): void
    {
        $this->assertInstanceOf(Key::class, (new Key('keyName'))->enableRemove());
    }

    public function testEnableRemoveException1(): void
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableRemove()->enableAdd();
    }

    public function testEnableRemoveException2(): void
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableRemove()->enableRename();
    }

    public function testEnableRename(): void
    {
        $this->assertInstanceOf(Key::class, (new Key('keyName'))->enableRename());
    }

    public function testEnableRenameException1(): void
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableRename()->enableAdd();
    }

    public function testEnableRenameException2(): void
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableRename()->enableRemove();
    }

    public function testIsAddKey(): void
    {
        $key = new Key('keyName');
        $this->assertFalse($key->isAddKey());
        $key->enableAdd();
        $this->assertTrue($key->isAddKey());
    }

    public function testIsRemoveKey(): void
    {
        $key = new Key('keyName');
        $this->assertFalse($key->isRemoveKey());
        $key->enableRemove();
        $this->assertTrue($key->isRemoveKey());
    }

    public function testIsRenameKey(): void
    {
        $key = new Key('keyName');
        $this->assertFalse($key->isRenameKey());
        $key->enableRename();
        $this->assertTrue($key->isRenameKey());
    }
}
