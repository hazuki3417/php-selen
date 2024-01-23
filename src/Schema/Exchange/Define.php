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
    public const KEY_ACTION_NONE   = 'none';
    public const KEY_ACTION_ADD    = 'add';
    public const KEY_ACTION_REMOVE = 'remove';
    public const KEY_ACTION_RENAME = 'rename';
    public const KEY_ACTIONS       = [
        self::KEY_ACTION_NONE,
        self::KEY_ACTION_ADD,
        self::KEY_ACTION_REMOVE,
        self::KEY_ACTION_RENAME,
    ];

    /** @var Key */
    public $key;

    /** @var \Selen\Schema\Exchange\KeyExchangeInterface|callable|null */
    public $keyExchangeExecute;

    /** @var \Selen\Schema\Exchange\ValueExchangeInterface|callable|null */
    public $valueExchangeExecute;

    /** @var ArrayDefine|null */
    public $arrayDefine;

    /** @var bool */
    private $haveCalledValue = false;

    /** @var bool */
    private $haveCalledArrayDefine = false;

    /**
     * インスタンスを生成します
     *
     * @return Define
     */
    private function __construct(Key $key)
    {
        $this->key = $key;
    }

    /**
     * @return Define
     */
    public static function noKey()
    {
        // TODO: noKeyが指定されたときのkeyActionの処理を実装する
        return new self(new Key(null));
    }

    /**
     * @param string|int                                                $name
     * @param \Selen\Schema\Exchange\KeyExchangeInterface|callable|null $execute
     *
     * @throws \InvalidArgumentException 引数の型が不正なときに発生します
     * @throws \ValueError               引数の値が不正なときに発生します
     *
     * @return Define
     */
    public static function key($name, string $action = self::KEY_ACTION_NONE, $execute = null)
    {
        $format = 'Invalid %s %s. expected %s %s.';

        if ($name === null) {
            $allowType = ['integer', 'string'];
            $mes       = \sprintf($format, '$name', 'type', 'type', \implode(', ', $allowType));
            throw new \InvalidArgumentException($mes);
        }

        if (!self::isAllowKeyAction($action)) {
            $mes = \sprintf($format, '$action', 'value', 'value', \implode(', ', self::KEY_ACTIONS));
            throw new \ValueError($mes);
        }

        /** @var bool[] */
        $allowTypeList = [
            \is_null($execute),
            \is_callable($execute),
            ($execute instanceof KeyExchangeInterface),
        ];

        if (!\in_array(true, $allowTypeList, true)) {
            $allowType = [null, 'callable', KeyExchangeInterface::class];
            $mes       = \sprintf($format, '$execute', 'type', 'type', \implode(', ', $allowType));
            throw new \InvalidArgumentException($mes);
        }

        $key = new Key($name);

        switch (true) {
            case $action === self::KEY_ACTION_ADD:
                $key = $key->enableAdd();
                break;
            case $action === self::KEY_ACTION_REMOVE:
                $key = $key->enableRemove();
                break;
            case $action === self::KEY_ACTION_RENAME:
                $key = $key->enableRename();
                break;
            default:
                break;
        }
        $self                     = new self($key);
        $self->keyExchangeExecute = $execute;

        return $self;
    }

    /**
     * @param \Selen\Schema\Exchange\ValueExchangeInterface|callable|null $execute
     *
     * @throws \LogicException           メソッドの呼び出し順が不正なときに発生します
     * @throws \InvalidArgumentException 引数の型が不正なときに発生します
     *
     * @return Define
     */
    public function value($execute = null)
    {
        if ($this->defineConflict()) {
            throw new \LogicException('Invalid method call. cannot call value method after arrayDefine.');
        }

        $allowTypeList = [
            \is_null($execute),
            \is_callable($execute),
            ($execute instanceof ValueExchangeInterface),
        ];

        if (!\in_array(true, $allowTypeList, true)) {
            $format    = 'Invalid %s %s. expected %s %s.';
            $allowType = [null, 'callable', ValueExchangeInterface::class];
            $mes       = \sprintf($format, '$execute', 'type', 'type', \implode(', ', $allowType));
            throw new \InvalidArgumentException($mes);
        }

        $this->haveCalledValue      = true;
        $this->valueExchangeExecute = $execute;
        return $this;
    }

    /**
     * @throws \LogicException メソッドの呼び出し順が不正なときに発生します
     *
     * @return Define
     *
     * @param Define[] $define
     */
    public function arrayDefine(Define ...$define)
    {
        if ($this->defineConflict()) {
            throw new \LogicException('Invalid method call. cannot call arrayDefine method after value.');
        }

        // NOTE: 引数の指定がない場合はそのまま通す（エラーにしない）

        $this->haveCalledArrayDefine = true;
        $this->arrayDefine           = new ArrayDefine(...$define);

        return $this;
    }

    /**
     * IndexArray（keyなし）か確認します
     *
     * @return bool IndexArrayの場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isIndexArrayDefine(): bool
    {
        return $this->key->getName() === null;
    }

    /**
     * AssocArray（keyあり）か確認します
     *
     * @return bool AssocArrayの場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isAssocArrayDefine(): bool
    {
        return $this->key->getName() !== null;
    }

    /**
     * keyの変換処理を実行するか判定します。
     *
     * @return bool 変換する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isKeyExchange(): bool
    {
        return
            $this->key->isAddKey()
            || $this->key->isRemoveKey()
            || $this->key->isRenameKey();
    }

    /**
     * valueの変換処理を実行するか判定します。
     *
     * @return bool 変換する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isValueExchange(): bool
    {
        return $this->arrayDefine === null;
    }

    /**
     * ネストされた定義が存在するか確認します
     *
     * @return bool 存在する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function nestedTypeDefineExists(): bool
    {
        return $this->arrayDefine !== null;
    }

    private static function isAllowKeyAction(string $name)
    {
        return \in_array($name, self::KEY_ACTIONS, true);
    }

    /**
     * 定義呼び出しが競合しているか確認します
     *
     * @return bool 競合する場合はtrueを、それ以外の場合はfalseを返します
     */
    private function defineConflict()
    {
        return $this->haveCalledValue || $this->haveCalledArrayDefine;
    }
}
