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
    /** @var \Selen\Schema\Validate\Define\Key */
    public $key;

    /** @var \Selen\Schema\Validate\ArrayDefine|null */
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
     * @return \Selen\Schema\Validate\Define
     */
    private function __construct(Key $key)
    {
        $this->key = $key;
    }

    /**
     * @return \Selen\Schema\Validate\Define
     */
    public static function noKey()
    {
        return new self(new Key(null, false));
    }

    /**
     * @param string|int $name
     *
     * @throws \InvalidArgumentException 引数の型が不正なときに発生します
     *
     * @return \Selen\Schema\Validate\Define
     */
    public static function key($name, bool $require)
    {
        $format = 'Invalid %s %s. expected %s %s.';

        if ($name === null) {
            $allowType = ['integer', 'string'];
            $mes       = \sprintf($format, '$name', 'type', 'type', \implode(', ', $allowType));
            throw new \InvalidArgumentException($mes);
        }

        return new self(new Key($name, $require));
    }

    /**
     * @param \Selen\Schema\Validate\ValueValidateInterface|callable ...$executes
     *
     * @throws \LogicException メソッドの呼び出し順が不正なときに発生します
     * @throws \InvalidArgumentException 引数の型が不正なときに発生します
     *
     * @return \Selen\Schema\Validate\Define
     */
    public function value(...$executes)
    {
        if ($this->haveCalledValue) {
            // value()->value()という呼び出し方をしたときに発生する
            throw new \LogicException('Invalid method call. value method cannot be called back to back.');
        }

        if ($this->haveCalledArrayDefine) {
            // arrayDefine()->value()という呼び出し方をしたときに発生する
            throw new \LogicException('Invalid method call. cannot call value method after arrayDefine.');
        }

        foreach ($executes as $execute) {
            $allowTypeList = [
                \is_callable($execute),
                ($execute instanceof ValueValidateInterface),
            ];

            if (!\in_array(true, $allowTypeList, true)) {
                $format    = 'Invalid %s %s. expected %s %s.';
                $allowType = [null, 'callable', ValueValidateInterface::class];
                $mes       = \sprintf($format, '$executes', 'type', 'type', \implode(', ', $allowType));
                throw new \InvalidArgumentException($mes);
            }
        }

        $this->haveCalledValue       = true;
        $this->valueValidateExecutes = $executes;
        return $this;
    }

    /**
     * @param \Selen\Schema\Validate\Define ...$define
     *
     * @throws \LogicException メソッドの呼び出し順が不正なときに発生します
     *
     * @return \Selen\Schema\Validate\Define
     */
    public function arrayDefine(Define ...$define)
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
