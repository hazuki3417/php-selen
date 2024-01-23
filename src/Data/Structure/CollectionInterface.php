<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

interface CollectionInterface extends ObjectsInterface
{
    /**
     * オブジェクトを追加します
     *
     * @param mixed $object 追加するオブジェクトを渡します
     *
     * @return bool 成功した場合はtrueを返します
     */
    public function add($object): bool;

    /**
     * オブジェクトを削除します
     *
     * @param mixed $object 削除するオブジェクトを渡します
     *
     * @return bool オブジェクトを削除できた場合はtrueを返します
     */
    public function remove($object): bool;
}
