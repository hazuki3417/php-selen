<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Str\Generator;

use PHPUnit\Framework\TestCase;
use Selen\Str\Generator\Random;

/**
 * @coversDefaultClass \Selen\Str\Generator\Random
 *
 * @see Random
 *
 * @internal
 */
class RandomTest extends TestCase
{
    public function testChar(): void
    {
        $pool      = 'abcde';
        $poolChars = \str_split($pool);

        $this->assertTrue(\in_array(Random::char($pool), $poolChars, true));
    }

    public function testStr(): void
    {
        $pool      = 'abcde';
        $poolChars = \str_split($pool);

        $randomStr   = Random::str($pool, 10);
        $randomChars = \str_split($randomStr);

        foreach ($randomChars as $randomChar) {
            $this->assertTrue(\in_array($randomChar, $poolChars, true));
        }
    }

    public function testAlpha(): void
    {
        $pool      = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $poolChars = \str_split($pool);

        $randomStr   = Random::alpha(10);
        $randomChars = \str_split($randomStr);

        foreach ($randomChars as $randomChar) {
            $this->assertTrue(\in_array($randomChar, $poolChars, true));
        }
    }

    public function testNum(): void
    {
        $pool      = '0123456789';
        $poolChars = \str_split($pool);

        $randomStr   = Random::num(10);
        $randomChars = \str_split($randomStr);

        foreach ($randomChars as $randomChar) {
            $this->assertTrue(\in_array($randomChar, $poolChars, true));
        }
    }

    public function testAlphaNum(): void
    {
        $pool      = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $poolChars = \str_split($pool);

        $randomStr   = Random::alphaNum(10);
        $randomChars = \str_split($randomStr);

        foreach ($randomChars as $randomChar) {
            $this->assertTrue(\in_array($randomChar, $poolChars, true));
        }
    }
}
