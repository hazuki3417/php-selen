<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Str;

use PHPUnit\Framework\TestCase;
use Selen\Str\Bom;

/**
 * @coversDefaultClass \Selen\Str\Bom
 *
 * @see Bom
 *
 * @internal
 */
class BomTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderExists(): array
    {
        return [
            'pattern001' => ['expected' => false, 'input' => 'test'],
            'pattern002' => ['expected' => true,  'input' => "\xef\xbb\xbf" . 'test'],
        ];
    }

    /**
     * @dataProvider dataProviderExists
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testExists($expected, $input): void
    {
        $this->assertSame($expected, Bom::exists($input));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderRemove(): array
    {
        return [
            'pattern001' => ['expected' => 'test',     'input' => "\xef\xbb\xbf" . 'test'],
            'pattern002' => ['expected' => 'test',     'input' => 'test' . "\xef\xbb\xbf"],
            'pattern003' => ['expected' => 'testtest', 'input' => 'test' . "\xef\xbb\xbf" . 'test'],
            'pattern004' => ['expected' => 'testtest', 'input' => 'test' . "\xef\xbb\xbf" . 'test' . "\xef\xbb\xbf"],
        ];
    }

    /**
     * @dataProvider dataProviderRemove
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testRemove($expected, $input): void
    {
        $this->assertSame($expected, Bom::remove($input));
    }
}
