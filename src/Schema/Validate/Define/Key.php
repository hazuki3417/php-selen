<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Define;

class Key
{
    /** @var string|int|null key名 */
    private $name;

    /** @var bool */
    private $require;

    /**
     * インスタンスを生成します
     *
     * @param string|int|null $name key名を指定します。index arrayの場合はnullを渡します。
     *
     * @return Key
     */
    public function __construct(string|int|null $name, bool $require)
    {
        $this->name    = $name;
        $this->require = $require;
    }

    /**
     * key名を取得します
     *
     * @return string|int|null key名を返します
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * keyの必須有無を取得します
     *
     * @return bool 必須の場合はtrueを、それ以外の場合はfalseを返します
     */
    public function getRequire()
    {
        return $this->require;
    }
}
