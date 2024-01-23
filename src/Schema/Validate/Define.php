<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate;

use Selen\Schema\Validate\Define\Key;

class Define
{
    /** @var Key */
    public $key;

    /** @var ArrayDefine|null */
    public $arrayDefine;

    /** @var (\Selen\Schema\Validate\ValueValidateInterface|callable)[] */
    public $valueValidateExecutes;

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
     * 添字配列（index）の定義を生成します
     */
    public static function noKey(): Define
    {
        return new self(new Key(null, false));
    }

    /**
     * 連想配列（assoc）の定義を生成します
     */
    public static function key(string|int $name, bool $require): Define
    {
        return new self(new Key($name, $require));
    }

    /**
     * @param ValueValidateInterface|callable $executes 検証値を渡します
     *
     * @throws \LogicException メソッドの呼び出し順が不正なときに発生します
     */
    public function value(ValueValidateInterface|callable ...$executes): Define
    {
        if ($this->haveCalledValue) {
            // value()->value()という呼び出し方をしたときに発生する
            throw new \LogicException('Invalid method call. value method cannot be called back to back.');
        }

        if ($this->haveCalledArrayDefine) {
            // arrayDefine()->value()という呼び出し方をしたときに発生する
            throw new \LogicException('Invalid method call. cannot call value method after arrayDefine.');
        }

        $this->haveCalledValue       = true;
        $this->valueValidateExecutes = $executes;
        return $this;
    }

    /**
     * @throws \LogicException メソッドの呼び出し順が不正なときに発生します
     *
     * @param Define $define 定義を指定します
     */
    public function arrayDefine(Define ...$define): Define
    {
        if ($this->haveCalledArrayDefine) {
            // arrayDefine()->arrayDefine()という呼び出し方をしたときに発生する
            throw new \LogicException('Invalid method call. arrayDefine method cannot be called back to back.');
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
     * keyの検証処理を実行するか判定します。
     *
     * @return bool 変換する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isKeyValidate(): bool
    {
        if ($this->key->getName() === null) {
            return false;
        }
        return $this->key->getRequire();
    }

    /**
     * valueの検証処理を実行するか判定します。
     *
     * @return bool 変換する場合はtrueを、それ以外の場合はfalseを返します
     */
    public function isValueValidate(): bool
    {
        return $this->valueValidateExecutes !== null;
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
}
