<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Define\Key\Test;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Define\Key;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Define\Key
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Define
 * @group Selen/Schema/Validate/Define/Key
 *
 * @see \Selen\Schema\Validate\Define\Key
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Define/Key
 *
 * @internal
 */
class KeyTest extends TestCase
{
    public function dataProviderConstruct()
    {
        return [
            'pattern001' => [
                'expected' => Key::class, 'input' => ['name' => 'keyName', 'require' => true], ],
            'pattern002' => [
                'expected' => Key::class, 'input' => ['name' => '0', 'require' => true], ],
            'pattern003' => [
                'expected' => Key::class, 'input' => ['name' => 0, 'require' => true], ],
            'pattern004' => [
                'expected' => Key::class, 'input' => ['name' => null, 'require' => true], ],
        ];
    }

    /**
     * @dataProvider dataProviderConstruct
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testConstruct($expected, $input)
    {
        $this->assertInstanceOf($expected, new Key($input['name'], $input['require']));
    }

    public function testConstructException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Key(false, true);
    }

    public function dataProviderGetName()
    {
        return [
            'pattern001' => ['expected' => 'keyName', 'input' => 'keyName'],
            'pattern002' => ['expected' => '0',       'input' => '0'],
            'pattern003' => ['expected' => 0,         'input' => 0],
            'pattern004' => ['expected' => null,      'input' => null],
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
        $this->assertSame($expected, (new Key($input, true))->getName());
    }

    public function dataProviderGetRequire()
    {
        return [
            'pattern001' => ['expected' => true,  'input' => true],
            'pattern002' => ['expected' => false, 'input' => false],
        ];
    }

    /**
     * @dataProvider dataProviderGetRequire
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetRequire($expected, $input)
    {
        $this->assertSame($expected, (new Key('keyName', $input))->getRequire());
    }
}
