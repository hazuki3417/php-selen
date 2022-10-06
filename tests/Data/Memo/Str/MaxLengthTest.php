<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Data;

use PHPUnit\Framework\TestCase;
use Selen\Data\Memo\Str\MaxLength;

/**
 * @coversDefaultClass \Selen\Data\Memo\Str\MaxLength
 *
 * @group Selen/Data
 * @group Selen/Data/Memo
 * @group Selen/Data/Memo/Str
 * @group Selen/Data/Memo/Str/MaxLength
 *
 * @see \Selen\Data\Memo\Str\MaxLength
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Data/Memo/Str/MaxLength
 *
 * @internal
 */
class MaxLengthTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new MaxLength();

        $this->assertInstanceOf(MaxLength::class, $instance);
    }

    public function testSet()
    {
        $instance = new MaxLength();

        $this->assertSame(true, $instance->set(''));
        $this->assertSame(true, $instance->set('12345'));
        $this->assertSame(false, $instance->set('1234'));
    }

    public function testSetException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $instance = new MaxLength();

        // typeNameで指定したデータ型以外を渡す
        $instance->set(true);
    }

    public function testGet()
    {
        $instance = new MaxLength();

        $this->assertSame(null, $instance->get());

        // 値が保持されるかテスト（初回）
        $this->assertSame(true, $instance->set('12345'));
        $this->assertSame('12345', $instance->get());

        // 値が保持されないかテスト（境界値テスト）
        $this->assertSame(false, $instance->set('1234'));
        $this->assertSame('12345', $instance->get());

        // 値が保持されるかテスト（境界値テスト）
        $this->assertSame(false, $instance->set('12345'));
        $this->assertSame('12345', $instance->get());

        // 値が保持されるかテスト（長い文字列）
        $this->assertSame(true, $instance->set('12345678'));
        $this->assertSame('12345678', $instance->get());

        // 値が上書きされないかテスト（同じ文字列長で異なる文字列）
        $this->assertSame(false, $instance->set('abcdefgh'));
        $this->assertSame('12345678', $instance->get());
    }
}
