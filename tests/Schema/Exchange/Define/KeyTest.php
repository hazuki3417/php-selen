<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Exchange\Define\Key;

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

    public function dataProviderGetName()
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
    public function testGetName($expected, $input)
    {
        $this->assertSame($expected, (new Key($input))->getName());
    }

    public function dataProviderSetName()
    {
        return [
            'pattern001' => ['expected' => true,  'input' => 'keyName'],
            'pattern002' => ['expected' => true,  'input' => '0'],
            'pattern003' => ['expected' => true,  'input' => 0],
            'pattern004' => ['expected' => true,  'input' => null],
            'pattern005' => ['expected' => false, 'input' => []],
        ];
    }

    /**
     * @dataProvider dataProviderSetName
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testSetName($expected, $input)
    {
        $key = new Key(null);
        $this->assertSame($expected, $key->setName($input));
    }

    public function testEnableAdd()
    {
        $this->assertInstanceOf(Key::class, (new Key('keyName'))->enableAdd());
    }

    public function testEnableAddException1()
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableAdd()->enableRemove();
    }

    public function testEnableAddException2()
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableAdd()->enableRename();
    }

    public function testEnableRemove()
    {
        $this->assertInstanceOf(Key::class, (new Key('keyName'))->enableRemove());
    }

    public function testEnableRemoveException1()
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableRemove()->enableAdd();
    }

    public function testEnableRemoveException2()
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableRemove()->enableRename();
    }

    public function testEnableRename()
    {
        $this->assertInstanceOf(Key::class, (new Key('keyName'))->enableRename());
    }

    public function testEnableRenameException1()
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableRename()->enableAdd();
    }

    public function testEnableRenameException2()
    {
        $this->expectException(\LogicException::class);
        (new Key('keyName'))->enableRename()->enableRemove();
    }

    public function testIsAddKey()
    {
        $key = new Key('keyName');
        $this->assertFalse($key->isAddKey());
        $key->enableAdd();
        $this->assertTrue($key->isAddKey());
    }

    public function testIsRemoveKey()
    {
        $key = new Key('keyName');
        $this->assertFalse($key->isRemoveKey());
        $key->enableRemove();
        $this->assertTrue($key->isRemoveKey());
    }

    public function testIsRenameKey()
    {
        $key = new Key('keyName');
        $this->assertFalse($key->isRenameKey());
        $key->enableRename();
        $this->assertTrue($key->isRenameKey());
    }
}
