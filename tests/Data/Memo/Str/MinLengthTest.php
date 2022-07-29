<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Test;

use PHPUnit\Framework\TestCase;
use Selen\Data\Memo\Str\MinLength;

/**
 * @coversDefaultClass \Selen\Data\Memo\Str\MinLength
 *
 * @group Selen/Data
 * @group Selen/Data/Memo
 * @group Selen/Data/Memo/Str
 * @group Selen/Data/Memo/Str/MinLength
 *
 * @see \Selen\Data\Memo\Str\MinLength
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Data/Memo/Str/MinLength
 *
 * @internal
 */
class MinLengthTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new MinLength();

        $this->assertInstanceOf(MinLength::class, $instance);
    }

    public function testSet()
    {
        $instance = new MinLength();

        $this->assertEquals(true, $instance->set('12345'));
        $this->assertEquals(true, $instance->set(''));
        $this->assertEquals(false, $instance->set('1234'));
    }

    public function testSetException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $instance = new MinLength();

        // typeNameで指定したデータ型以外を渡す
        $instance->set(true);
    }

    public function testGet()
    {
        $instance = new MinLength();

        $this->assertEquals(null, $instance->get());

        // 値が保持されるかテスト（初回）
        $this->assertEquals(true, $instance->set('12345'));
        $this->assertEquals('12345', $instance->get());

        // 値が保持されるかテスト（境界値テスト）
        $this->assertEquals(true, $instance->set('1234'));
        $this->assertEquals('1234', $instance->get());

        // 値が保持されないかテスト（境界値テスト）
        $this->assertEquals(false, $instance->set('12345'));
        $this->assertEquals('1234', $instance->get());

        // 値が保持されるかテスト（短い文字）
        $this->assertEquals(true, $instance->set('123'));
        $this->assertEquals('123', $instance->get());

        // 値が上書きされないかテスト（同じ文字列長で異なる文字列）
        $this->assertEquals(false, $instance->set('abc'));
        $this->assertEquals('123', $instance->get());
    }
}
