<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

/**
 * @extends \Iterator<mixed>
 */
interface StackInterface extends ObjectsInterface, \Iterator
{
    /**
     * プッシュします
     *
     * @param mixed $object オブジェクトを渡します
     */
    public function push($object): void;

    /**
     * ポップします
     *
     * @return mixed オブジェクトを返します
     */
    public function pop();
}
