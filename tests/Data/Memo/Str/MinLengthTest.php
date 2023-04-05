<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Data;

use PHPUnit\Framework\TestCase;
use Selen\Data\Memo\Str\MinLength;

/**
 * @coversDefaultClass \Selen\Data\Memo\Str\MinLength
 *
 * @see \Selen\Data\Memo\Str\MinLength
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

        $this->assertSame(true, $instance->set('12345'));
        $this->assertSame(true, $instance->set(''));
        $this->assertSame(false, $instance->set('1234'));
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

        $this->assertSame(null, $instance->get());

        // 値が保持されるかテスト（初回）
        $this->assertSame(true, $instance->set('12345'));
        $this->assertSame('12345', $instance->get());

        // 値が保持されるかテスト（境界値テスト）
        $this->assertSame(true, $instance->set('1234'));
        $this->assertSame('1234', $instance->get());

        // 値が保持されないかテスト（境界値テスト）
        $this->assertSame(false, $instance->set('12345'));
        $this->assertSame('1234', $instance->get());

        // 値が保持されるかテスト（短い文字）
        $this->assertSame(true, $instance->set('123'));
        $this->assertSame('123', $instance->get());

        // 値が上書きされないかテスト（同じ文字列長で異なる文字列）
        $this->assertSame(false, $instance->set('abc'));
        $this->assertSame('123', $instance->get());
    }
}
