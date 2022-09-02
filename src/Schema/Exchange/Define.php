<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Exchange;

use Selen\Schema\Exchange\Define\Key;

class Define
{
    /** @var \Selen\Schema\Exchange\Define\Key */
    public $key;

    /** @var \Selen\Schema\Exchange\ValueExchangeInterface[]|callable[] */
    public $executes;

    /** @var \Selen\Schema\Exchange\ArrayDefine|null */
    public $arrayDefine;

    /** @var bool */
    private $haveCalledExchange = false;

    /** @var bool */
    private $haveCalledArrayDefine = false;


    private function __construct(Key $key)
    {
        $this->key = $key;
    }

    /**
     * @return \Selen\Schema\Exchange\Define
     */
    public static function noKey()
    {
        return new self(new Key(null));
    }

    /**
     * @param string|int $name
     *
     * @return \Selen\Schema\Exchange\Define
     */
    public static function key($name)
    {
        if ($name === null) {
            throw new \InvalidArgumentException('型が不正');
        }
        return new self(new Key($name));
    }

    /**
     * @param \Selen\Schema\Exchange\ValueExchangeInterface|callable ...$executes
     *
     * @return \Selen\Schema\Exchange\Define
     */
    public function exchange(...$executes)
    {
        if ($this->defineConflict()) {
            throw new \RuntimeException('定義の仕方が不正です');
        }

        // NOTE: 引数の指定がない場合はそのまま通す（エラーにしない）

        foreach ($executes as $execute) {
            $isCallable = \is_callable($execute);
            $isInterface = $execute instanceof ValueExchangeInterface;

            if ($isCallable || $isInterface) {
                continue;
            }
            throw new \InvalidArgumentException('引数の型が不正です');
        }

        $this->haveCalledExchange = true;
        $this->executes = $executes;
        return $this;
    }

    /**
     * @param Define ...$define
     *
     * @return \Selen\Schema\Exchange\Define
     */
    public function arrayDefine(Define ...$define)
    {
        if ($this->defineConflict()) {
            throw new \RuntimeException('定義の仕方が不正です');
        }

        // NOTE: 引数の指定がない場合はそのまま通す（エラーにしない）

        $this->haveCalledArrayDefine = true;
        $this->arrayDefine = new ArrayDefine(...$define);

        return $this;
    }

    /**
     * IndexArray（keyなし）か確認します
     *
     * @return bool IndexArrayの場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isIndexArrayDefine(): bool
    {
        return $this->key->name() === null;
    }

    /**
     * AssocArray（keyあり）か確認します
     *
     * @return bool AssocArrayの場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isAssocArrayDefine(): bool
    {
        return $this->key->name() !== null;
    }

    /**
     * ネストされた定義が存在するか確認します
     *
     * @return bool 存在する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function nestedTypeDefineExists(): bool
    {
        return $this->executes === null && $this->arrayDefine !== null;
    }

    /**
     * 定義呼び出しが競合しているか確認します
     *
     * @return bool 競合する場合はtrueを、それ以外の場合はfalseを返します
     */
    private function defineConflict()
    {
        return $this->haveCalledExchange || $this->haveCalledArrayDefine;
    }
}
