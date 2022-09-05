<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Exchange\Define;

use InvalidArgumentException;
use LogicException;
use Selen\Data\Types;

class Key
{
    /** @var bool keyの追加処理フラグ */
    private $haveCalledAdd = false;

    /** @var bool keyの削除処理フラグ */
    private $haveCalledRemove = false;

    /** @var bool keyのリネーム処理フラグ */
    private $haveCalledRename = false;

    /** @var string|int|null key名 */
    private $name;

    /** @var string[] */
    private $nameAllowType = ['string', 'integer', 'null'];

    /**
     * インスタンスを生成します
     *
     * @param string|int|null $name key名を指定します。index arrayの場合はnullを渡します。
     *
     * @return \Selen\Schema\Exchange\Define\Key
     *
     * @throws \InvalidArgumentException 引数の型が不正なときに発生します
     */
    public function __construct($name)
    {
        if (!$this->verifyNameType($name)) {
            $format = 'Invalid $name type. expected type %s.';
            $mes = \sprintf($format, \implode(', ', $this->nameAllowType));
            throw new InvalidArgumentException($mes);
        }
        $this->name = $name;
    }

    /**
     * keyの追加処理を有効にします
     *
     * @return \Selen\Schema\Exchange\Define\Key
     *
     * @throws \LogicException メソッドの呼び出し順が不正なときに発生します
     */
    public function enableAdd()
    {
        if ($this->callConflict()) {
            $mes = 'Invalid method call. cannot call enableRemove or enableRename method after enableAdd.';
            throw new LogicException($mes);
        }

        $this->haveCalledAdd = true;
        return $this;
    }

    /**
     * keyの削除処理を有効にします
     *
     * @return \Selen\Schema\Exchange\Define\Key
     *
     * @throws \LogicException メソッドの呼び出し順が不正なときに発生します
     */
    public function enableRemove()
    {
        if ($this->callConflict()) {
            $mes = 'Invalid method call. cannot call enableAdd or enableRename method after enableRemove.';
            throw new LogicException($mes);
        }

        $this->haveCalledRemove = true;
        return $this;
    }

    /**
     * keyのリネーム処理を有効にします
     *
     * @return \Selen\Schema\Exchange\Define\Key
     *
     * @throws \LogicException メソッドの呼び出し順が不正なときに発生します
     */
    public function enableRename()
    {
        if ($this->callConflict()) {
            $mes = 'Invalid method call. cannot call enableAdd or enableRemove method after enableRename.';
            throw new LogicException($mes);
        }

        $this->haveCalledRename = true;
        return $this;
    }

    /**
     * keyの追加処理を実行するかどうか返します。
     *
     * @return bool 処理する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isAddKey()
    {
        return $this->haveCalledAdd;
    }

    /**
     * keyの削除処理を実行するかどうか返します
     *
     * @return bool 処理する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isRemoveKey()
    {
        return $this->haveCalledRemove;
    }

    /**
     * keyのリネーム処理を実行するかどうか返します
     *
     * @return bool 処理する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isRenameKey()
    {
        return $this->haveCalledRename;
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
     * key名を設定します
     *
     * @param string|int|null $value
     *
     * @return bool 成功した場合はtrueを、それ以外の場合はfalseを返します
     */
    public function setName($value)
    {
        $result = $this->verifyNameType($value);

        if ($result) {
            $this->name = $value;
        }
        return $result;
    }

    /**
     * key名の型を検証します
     *
     * @param string|int|null $value
     *
     * @return bool 合格した場合はtrueを、それ以外の場合はfalseを返します
     */
    private function verifyNameType($value)
    {
        return Types::validate($value, ...$this->nameAllowType);
    }

    /**
     * keyの追加・削除・リネームの呼び出しが競合しているか確認します
     *
     * @return bool 競合する場合はtrueを、それ以外の場合はfalseを返します
     */
    private function callConflict()
    {
        return
            $this->haveCalledAdd
            || $this->haveCalledRemove
            || $this->haveCalledRename;
    }
}
