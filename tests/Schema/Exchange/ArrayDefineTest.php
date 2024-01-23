<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Exchange\ArrayDefine;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Exchange\ArrayDefine;
use Selen\Schema\Exchange\Define;

/**
 * @coversDefaultClass \Selen\Schema\Exchange\ArrayDefine
 *
 * @see ArrayDefine
 *
 * @internal
 */
class ArrayDefineTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(ArrayDefine::class, new ArrayDefine(
            Define::key('keyName1'),
            Define::key('keyName2'),
            Define::key('keyName3')
        ));
        $this->assertInstanceOf(ArrayDefine::class, new ArrayDefine(
            Define::key('keyName'),
            Define::key('0'),
            Define::key(0)
        ));
        $this->assertInstanceOf(ArrayDefine::class, new ArrayDefine(
            Define::noKey()
        ));
    }

    public function testConstructException1()
    {
        // keyなしの定義が複数存在するケース（想定していない定義）
        $this->expectException(\LogicException::class);
        new ArrayDefine(
            Define::noKey(),
            Define::noKey()
        );
    }

    public function testConstructException2()
    {
        // keyあり・なしの定義が混在するケース（想定していない定義）
        $this->expectException(\LogicException::class);
        new ArrayDefine(
            Define::key('keyName'),
            Define::noKey()
        );
    }
}
