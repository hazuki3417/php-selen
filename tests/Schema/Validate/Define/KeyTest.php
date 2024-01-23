<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Define;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Define\Key;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Define\Key
 *
 * @see Key
 *
 * @internal
 */
class KeyTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderConstruct(): array
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
    public function testConstruct($expected, $input): void
    {
        $this->assertInstanceOf($expected, new Key($input['name'], $input['require']));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderGetName(): array
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
    public function testGetName($expected, $input): void
    {
        $this->assertSame($expected, (new Key($input, true))->getName());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderGetRequire(): array
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
    public function testGetRequire($expected, $input): void
    {
        $this->assertSame($expected, (new Key('keyName', $input))->getRequire());
    }
}
