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
    public const KEY_ACTION_NONE = 'none';
    public const KEY_ACTION_ADD = 'add';
    public const KEY_ACTION_REMOVE = 'remove';
    public const KEY_ACTION_RENAME = 'rename';

    /** @var \Selen\Schema\Exchange\Define\Key */
    public $key;

    /** @var \Selen\Schema\Exchange\KeyExchangeInterface|callable|null */
    public $keyExchangeExecute;

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
        // TODO: noKeyが指定されたときのkeyActionの処理を実装する
        return new self(new Key(null));
    }

    /**
     * @param string|int $name
     * @param \Selen\Schema\Exchange\KeyExchangeInterface|callable|null $execute
     *
     * @return \Selen\Schema\Exchange\Define
     */
    public static function key($name, string $action = self::KEY_ACTION_NONE, $execute = null)
    {
        if ($name === null) {
            throw new \InvalidArgumentException('$nameの型が不正');
        }

        if (!self::isAllowKeyAction($action)) {
            throw new \InvalidArgumentException('$actionの値が不正');
        }

        $isExecuteNull = \is_null($execute);
        $isExecuteCallable = \is_callable($execute);
        $isExecuteInterface = $execute instanceof KeyExchangeInterface;
        $isAllowExecute =
            $isExecuteNull || $isExecuteCallable || $isExecuteInterface;

        if (!$isAllowExecute) {
            throw new \InvalidArgumentException('$executeの型が不正');
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
        $self = new self($key);
        $self->keyExchangeExecute = $execute;

        return $self;
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
     * @param \Selen\Schema\Exchange\Define ...$define
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
     * 変換処理を実行するか判定します。
     *
     * @return bool 変換する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isExchange(): bool
    {
        return $this->isKeyExchange() || $this->isValueExchange();
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
        // NOTE: defineConflictでチェックしているので、片方のみの判定でも良い
        return $this->executes !== null && $this->arrayDefine === null;
    }

    /**
     * ネストされた定義が存在するか確認します
     *
     * @return bool 存在する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function nestedTypeDefineExists(): bool
    {
        // NOTE: defineConflictでチェックしているので、片方のみの判定でも良い
        return $this->executes === null && $this->arrayDefine !== null;
    }

    private static function isAllowKeyAction(string $name)
    {
        $actions = [
            self::KEY_ACTION_NONE,
            self::KEY_ACTION_ADD,
            self::KEY_ACTION_REMOVE,
            self::KEY_ACTION_RENAME,
        ];

        return \in_array($name, $actions, true);
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
