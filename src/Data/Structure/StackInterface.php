<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

interface StackInterface extends ObjectsInterface, \Iterator
{
    public function push($object);

    public function pop();
}
