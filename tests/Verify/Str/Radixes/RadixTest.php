<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Verify\Str\Radixes;

use LogicException;
use PHPUnit\Framework\TestCase;
use Selen\Verify\Str\Radixes\Radix;

/**
 * @coversDefaultClass \Selen\Verify\Str\Radixes\Radix
 *
 * @see \Selen\Verify\Str\Radixes\Radix
 *
 * @internal
 */
class RadixTest extends TestCase
{
    public function dataProviderVerify()
    {
        return [
            'pattern001' => ['expected' => true, 'input' => ['num' => '0', 'base' => 2]],
            'pattern002' => ['expected' => true, 'input' => ['num' => '0', 'base' => 3]],
            'pattern003' => ['expected' => true, 'input' => ['num' => '0', 'base' => 4]],
            'pattern004' => ['expected' => true, 'input' => ['num' => '0', 'base' => 5]],
            'pattern005' => ['expected' => true, 'input' => ['num' => '0', 'base' => 6]],
            'pattern006' => ['expected' => true, 'input' => ['num' => '0', 'base' => 7]],
            'pattern007' => ['expected' => true, 'input' => ['num' => '0', 'base' => 8]],
            'pattern008' => ['expected' => true, 'input' => ['num' => '0', 'base' => 9]],
            'pattern009' => ['expected' => true, 'input' => ['num' => '0', 'base' => 10]],
            'pattern010' => ['expected' => true, 'input' => ['num' => '0', 'base' => 16]],
            'pattern011' => ['expected' => true, 'input' => ['num' => '0', 'base' => 26]],
        ];
    }

    /**
     * @dataProvider dataProviderVerify
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testVerify($expected, $input)
    {
        $this->assertSame($expected, Radix::verify($input['num'], $input['base']));
    }

    public function testVerifyException1()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Does not support validation of the specified radix');
        Radix::verify('0', 32);
    }
}
