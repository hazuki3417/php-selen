<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Data;

use PHPUnit\Framework\TestCase;
use Selen\Data\AbstractMemo;

/**
 * @coversDefaultClass \Selen\Data\AbstractMemo
 *
 * @group Selen/Data
 * @group Selen/Data/AbstractMemo
 *
 * @see \Selen\Data\AbstractMemo
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Data/AbstractMemo
 *
 * @internal
 */
class AbstractMemoTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new TestMemo('string');

        $this->assertInstanceOf(TestMemo::class, $instance);
    }

    public function testSet()
    {
        $instance = new TestMemo();

        $this->assertSame(true, $instance->set(''));
        $this->assertSame(true, $instance->set('12345'));
        $this->assertSame(false, $instance->set('1234'));
    }

    public function testSetException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $instance = new TestMemo();

        // typeNameで指定したデータ型以外を渡す
        $instance->set(true);
    }

    public function testGet()
    {
        $instance = new TestMemo();

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
    }
}

/**
 * テストクラス。長い文字列が渡されたら値を保持するクラスとして実装
 */
class TestMemo extends AbstractMemo
{
    protected function typeName(): string
    {
        return 'string';
    }

    protected function condition($object): bool
    {
        if ($this->object === null) {
            // nullなら値を保持する
            return true;
        }
        // キャッシュ側の文字列長を取得
        $memoStrLength = strlen($this->object);
        // INPUT側の文字列長を取得
        $argStrLength = strlen($object);

        return $memoStrLength < $argStrLength;
    }
}
