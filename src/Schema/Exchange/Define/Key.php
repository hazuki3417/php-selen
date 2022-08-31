<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Exchange\Define;

use Selen\Data\Types;

class Key
{
    /** @var string|int|null */
    private $name;

    /**
     * Keyインスタンスを作成します
     *
     * @param string|int|null $name key名を設定します
     */
    public function __construct($name)
    {
        if (!Types::validate($name, ...['string', 'integer', 'null'])) {
            throw new \InvalidArgumentException('型が不正');
        }

        $this->name = $name;
    }

    /**
     * key名を返します
     *
     * @return string|int|null
     */
    public function name()
    {
        return $this->name;
    }
}
