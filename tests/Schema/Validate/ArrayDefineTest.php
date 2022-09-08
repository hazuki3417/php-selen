<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\ArrayDefine\Test;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\ArrayDefine;
use Selen\Schema\Validate\Define;

/**
 * @coversDefaultClass \Selen\Schema\Validate\ArrayDefine
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/ArrayDefine
 *
 * @see \Selen\Schema\Validate\ArrayDefine
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/ArrayDefine
 *
 * @internal
 */
class ArrayDefineTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(ArrayDefine::class, new ArrayDefine(
            Define::key('keyName1', true),
            Define::key('keyName2', true),
            Define::key('keyName3', true)
        ));
        $this->assertInstanceOf(ArrayDefine::class, new ArrayDefine(
            Define::key('keyName', true),
            Define::key('0', true),
            Define::key(0, true)
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
            Define::key('keyName', true),
            Define::noKey()
        );
    }
}
