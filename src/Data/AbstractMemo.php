<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

use Selen\DataStructure\Types;

/**
 * 値を保持するクラス
 */
abstract class AbstractMemo implements MemoInterface
{
    /**
     * @var mixed 保持する値を格納する変数
     */
    protected $object;

    /**
     * 保持する値を渡します
     *
     * @param mixed $object
     *
     * @return bool 値を保持した場合はtrueを、それ以外の場合はfalseを返します
     *
     * @throws \InvalidArgumentException 値の型が不正なときに発生します
     */
    public function set($object): bool
    {
        $isExpectedType = Types::validate($this->typeName(), $object);

        if (!$isExpectedType) {
            throw new \InvalidArgumentException('Invalid argument type.');
        }

        if ($this->condition($object)) {
            $this->object = $object;
            return true;
        }
        return false;
    }

    /**
     * 保持した値を取得します
     *
     * @return mixed 保持した値を返します
     */
    public function get()
    {
        return $this->object;
    }

    /**
     * 値を保持する条件を満たしているか判定します
     *
     * @param mixed $object
     *
     * @return bool 条件に一致している場合はtrueを、それ以外の場合はfalseを返します
     */
    abstract protected function condition($object): bool;

    /**
     * 保持する値のデータ型を指定します
     *
     * @return string データ型の名称を返します
     */
    abstract protected function typeName(): string;
}
