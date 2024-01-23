<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

interface ObjectsInterface
{
    /**
     * 配列が空であることを確認します。
     *
     * @return bool 配列が空の場合はtrue、それ以外はfalseを返します
     */
    public function isEmpty(): bool;

    /**
     * 配列が空でないことを確認します。
     *
     * @return bool 配列が空でない場合はtrue、それ以外はfalseを返します
     */
    public function isNotEmpty(): bool;

    /**
     * 配列のサイズを取得します。
     *
     * @return int 配列のサイズを返します
     */
    public function size(): int;

    /**
     * 配列をクリアします
     */
    public function clear(): void;

    /**
     * オブジェクトを配列で取得します。
     *
     * @return array<mixed,mixed> オブジェクトを返します
     */
    public function toArray(): array;
}
