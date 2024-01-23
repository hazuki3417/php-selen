<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema;

use Selen\Schema\Exchange\ArrayDefine;
use Selen\Schema\Exchange\KeyExchangeInterface;
use Selen\Schema\Exchange\ValueExchangeInterface;

class Exchanger
{
    /** @var \Selen\Schema\Exchange\KeyExchangeInterface|callable|null */
    private $keyExchangesExecute;

    /** @var \Selen\Schema\Exchange\ValueExchangeInterface|callable|null */
    private $valueExchangesExecute;

    /** @var Exchange\ArrayDefine|null */
    private $arrayDefine;

    /**
     * インスタンスを生成します
     *
     * @return Exchanger
     */
    private function __construct()
    {
    }

    /**
     * インスタンスを生成します
     */
    public static function new(): Exchanger
    {
        return new self();
    }

    /**
     * keyの変換処理を設定します（全体設定）
     *
     * @param \Selen\Schema\Exchange\KeyExchangeInterface|callable|null $execute
     */
    public function key($execute): Exchanger
    {
        /** @var bool[] */
        $allowTypeList = [
            \is_null($execute),
            \is_callable($execute),
            ($execute instanceof KeyExchangeInterface),
        ];

        if (!\in_array(true, $allowTypeList, true)) {
            $format    = 'Invalid $execute type. expected type %s.';
            $allowType = [null, 'callable', KeyExchangeInterface::class];
            $mes       = \sprintf($format, \implode(', ', $allowType));
            throw new \InvalidArgumentException($mes);
        }

        $this->keyExchangesExecute = $execute;
        return $this;
    }

    /**
     * valueの変換処理を設定します（全体設定）
     *
     * @param \Selen\Schema\Exchange\ValueExchangeInterface|callable|null $execute
     */
    public function value($execute): Exchanger
    {
        /** @var bool[] */
        $allowTypeList = [
            \is_null($execute),
            \is_callable($execute),
            ($execute instanceof KeyExchangeInterface),
        ];

        if (!\in_array(true, $allowTypeList, true)) {
            $format    = 'Invalid $execute type. expected type %s.';
            $allowType = [null, 'callable', KeyExchangeInterface::class];
            $mes       = \sprintf($format, \implode(', ', $allowType));
            throw new \InvalidArgumentException($mes);
        }

        $this->valueExchangesExecute = $execute;
        return $this;
    }

    /**
     * key・valueの変換処理を設定します（個別設定）
     *
     * @param ?\Selen\Schema\Exchange\ArrayDefine $arrayDefine
     */
    public function arrayDefine(?ArrayDefine $arrayDefine): Exchanger
    {
        $this->arrayDefine = $arrayDefine;
        return $this;
    }

    /**
     * 変換処理を実行します
     *
     * @param array $input 変換する配列を渡します
     *
     * @return array 変換した配列を返します
     */
    public function execute(array $input)
    {
        $input = $this->defineRoutine($input, $this->arrayDefine);
        return $this->inputRoutine($input);
    }

    /**
     * 定義した配列形式に変換します（個別設定）
     *
     * @param array       $input       変換する配列を渡します
     * @param ArrayDefine $arrayDefine 変換の定義を渡します
     *
     * @return array 変換した配列を返します
     */
    private function defineRoutine(
        array $input,
        ?ArrayDefine $arrayDefine
    ) {
        if ($arrayDefine === null) {
            // 変換の定義がないときの処理
            return $input;
        }

        // 変換の定義があるときの処理

        /** @var Exchange\Define $define */
        foreach ($arrayDefine->defines as $define) {
            if ($define->nestedTypeDefineExists()) {
                // ネストされた定義なら再帰処理を行う

                if ($define->key->getName() !== null) {
                    // ネストされた定義 + keyがnull以外のとき = keyありのArrayObject形式の定義
                    // assoc配列の変換処理
                    if (!\array_key_exists($define->key->getName(), $input)) {
                        continue;
                    }

                    // 定義したkeyに一致するkeyがinput側にあったとき
                    $input[$define->key->getName()] = $this->defineRoutine(
                        $input[$define->key->getName()],
                        $define->arrayDefine
                    );
                    continue;
                }
                // ネストされた定義 + keyがnullのとき = keyなしのArrayObject形式の定義
                $inputItems = $input;

                if (!\is_array($inputItems)) {
                    // inputItemsが配列以外のときは何もしない
                    continue;
                }

                foreach ($inputItems as $index => $inputItem) {
                    if (!\is_array($inputItem)) {
                        // inputItemが配列以外のときは何もしない
                        continue;
                    }
                    $input[$index] = $this->defineRoutine(
                        $input[$index],
                        $define->arrayDefine
                    );
                }
                continue;
            }

            // ネストされていない定義なら変換処理へ進む
            if ($define->isKeyExchange()) {
                // keyの変換処理
                if ($define->key->isRemoveKey()) {
                    unset($input[$define->key->getName()]);
                    // NOTE: keyを消した場合は値の変換は必要ないので抜ける
                    continue;
                }

                if ($define->key->isAddKey()) {
                    $addKeyDefaultValue = null;

                    if (!\array_key_exists($define->key->getName(), $input)) {
                        // NOTE: 存在しない場合はkeyを追加して値を初期化する。
                        $input[$define->key->getName()] = $addKeyDefaultValue;
                    }
                }

                if ($define->key->isRenameKey()) {
                    $beforeName = $define->key->getName();
                    $afterName  = $this->keyExchange(
                        $define->keyExchangeExecute,
                        $beforeName
                    );
                    $tmpValue = $input[$beforeName];
                    unset($input[$beforeName]);
                    $input[$afterName] = $tmpValue;
                    $define->key->setName($afterName);
                }
            }

            if ($define->isValueExchange()) {
                // valueの変換処理
                if ($define->isAssocArrayDefine()) {
                    // key定義ありのときの処理

                    $keyExists = \array_key_exists($define->key->getName(), $input);

                    if (!$keyExists) {
                        // NOTE: 定義側にkeyが存在し、入力側にkeyがないときは処理しない
                        continue;
                    }

                    $input[$define->key->getName()] = $this->valueExchange(
                        $define->valueExchangeExecute,
                        $input[$define->key->getName()]
                    );
                    continue;
                }

                if ($define->isIndexArrayDefine()) {
                    // key定義なしのときの処理
                    foreach ($input as $key => $value) {
                        $input[$key] = $this->valueExchange($define->valueExchangeExecute, $value);
                    }
                    continue;
                }
            }
        }
        return $input;
    }

    /**
     * 定義した配列形式に変換します（全体設定）
     *
     * @param array $input 変換する配列を渡します
     *
     * @return array 変換した配列を返します
     */
    private function inputRoutine(array $input)
    {
        if (!$this->isExchanges()) {
            // 全体の変換処理が定義されていないなら入力値をそのまま返す
            return $input;
        }

        // 全体の変換処理が定義されているなら入力側のループ処理を行う
        foreach ($input as $key => $value) {
            if ($this->isKeyExchanges()) {
                $beforeName = $key;
                $afterName  = $this->keyExchange(
                    $this->keyExchangesExecute,
                    $beforeName
                );
                $tmpValue = $input[$beforeName];
                unset($input[$beforeName]);
                $input[$afterName] = $tmpValue;
                $key               = $afterName;
            }

            if ($this->isValueExchanges()) {
                $input[$key] = $this->valueExchange(
                    $this->valueExchangesExecute,
                    $input[$key]
                );
            }

            if (\is_array($value)) {
                // 値が配列なら再帰処理を行う
                $input[$key] = $this->inputRoutine(
                    $input[$key]
                );
                continue;
            }
        }
        return $input;
    }

    /**
     * 変換処理を実行するかどうか判定します。
     *
     * @return bool 変換する場合はtrueを、それ以外の場合はfalseを返します
     */
    private function isExchanges()
    {
        return $this->isKeyExchanges() || $this->isValueExchanges();
    }

    /**
     * keyの変換処理を実行するかどうか判定します。
     *
     * @return bool 変換する場合はtrueを、それ以外の場合はfalseを返します
     */
    private function isKeyExchanges()
    {
        return $this->keyExchangesExecute !== null;
    }

    /**
     * valueの変換処理を実行するかどうか判定します。
     *
     * @return bool 変換する場合はtrueを、それ以外の場合はfalseを返します
     */
    private function isValueExchanges()
    {
        return $this->valueExchangesExecute !== null;
    }

    /**
     * keyの変換処理を行います
     *
     * @param \Selen\Schema\Exchange\KeyExchangeInterface|callable|null $execute
     * @param string                                                    $key
     *
     * @return string
     */
    private function keyExchange($execute, $key)
    {
        if ($execute instanceof KeyExchangeInterface) {
            return $execute->execute($key);
        }

        if (\is_callable($execute)) {
            return $execute($key);
        }

        return $key;
    }

    /**
     * 値の変換処理を行います
     *
     * @param \Selen\Schema\Exchange\ValueExchangeInterface|callable|null $execute
     * @param mixed                                                       $value
     *
     * @return mixed
     */
    private function valueExchange($execute, $value)
    {
        if ($execute instanceof ValueExchangeInterface) {
            return $execute->execute($value);
        }

        if (\is_callable($execute)) {
            return $execute($value);
        }

        return $value;
    }
}
