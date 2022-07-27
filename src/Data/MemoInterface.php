<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

interface MemoInterface
{
    /**
     * 保持する値を渡します
     *
     * @param mixed $object
     *
     * @return bool 値を保持した場合はtrueを、それ以外の場合はfalseを返します
     *
     * @throws \InvalidArgumentException 値の型が不正なときに発生します
     */
    public function set($object): bool;

    /**
     * 保持した値を取得します
     *
     * @return mixed 保持した値を返します
     */
    public function get();
}
