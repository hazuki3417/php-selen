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
interface QueueInterface extends ObjectsInterface, \Iterator
{
    /**
     * エンキューします
     *
     * @param mixed $object オブジェクトを渡します
     */
    public function enqueue($object): void;

    /**
     * デキューします
     *
     * @return mixed オブジェクトを返します
     */
    public function dequeue();
}
