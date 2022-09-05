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

    /** @var \Selen\Schema\Exchange\ArrayDefine||null */
    private $arrayDefine;

    /**
     * インスタンスを生成します
     *
     * @return \Selen\Schema\Exchanger
     */
    private function __construct()
    {
    }

    /**
     * インスタンスを生成します
     *
     * @return \Selen\Schema\Exchanger
     */
    public static function new()
    {
        return new self();
    }

    /**
     * keyの変換処理を設定します（全体設定）
     *
     * @param \Selen\Schema\Exchange\KeyExchangeInterface|callable|null $execute
     *
     * @return \Selen\Schema\Exchanger
     */
    public function key($execute)
    {
        /** @var bool[] */
        $allowTypeList = [
            \is_null($execute),
            \is_callable($execute),
            ($execute instanceof KeyExchangeInterface),
        ];

        if (!\in_array(true, $allowTypeList, true)) {
            $format = 'Invalid $execute type. expected type %s.';
            $allowType = [null, 'callable', KeyExchangeInterface::class];
            $mes = \sprintf($format, \implode(', ', $allowType));
            throw new \InvalidArgumentException($mes);
        }

        $this->keyExchangesExecute = $execute;
        return $this;
    }

    /**
     * valueの変換処理を設定します（全体設定）
     *
     * @param \Selen\Schema\Exchange\ValueExchangeInterface|callable|null $execute
     *
     * @return \Selen\Schema\Exchanger
     */
    public function value($execute)
    {
        /** @var bool[] */
        $allowTypeList = [
            \is_null($execute),
            \is_callable($execute),
            ($execute instanceof KeyExchangeInterface),
        ];

        if (!\in_array(true, $allowTypeList, true)) {
            $format = 'Invalid $execute type. expected type %s.';
            $allowType = [null, 'callable', KeyExchangeInterface::class];
            $mes = \sprintf($format, \implode(', ', $allowType));
            throw new \InvalidArgumentException($mes);
        }

        $this->valueExchangesExecute = $execute;
        return $this;
    }

    /**
     * key・valueの変換処理を設定します（個別設定）
     *
     * @return \Selen\Schema\Exchanger
     *
     * @param ?ArrayDefine $arrayDefine
     */
    public function arrayDefine(?ArrayDefine $arrayDefine)
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
        return $this->routine($input, $this->arrayDefine);
    }

    /**
     * 定義した配列形式に変換します
     *
     * @param array $input 変換する配列を渡します
     * @param ArrayDefine $arrayDefine 変換の定義を渡します
     *
     * @return array 変換した配列を返します
     */
    private function routine(
        array $input,
        ?ArrayDefine $arrayDefine
    ) {
        /**
         * TODO: コードが長いのでリファクタリングが必要。下記の粒度で分割
         *       - 定義側のループ内処理（defineRoutine）
         *       - input側のループ内処理（inputRoutine）
         */

        if ($arrayDefine !== null) {
            $defines = $arrayDefine->defines;

            // 定義側のループ処理
            /** @var \Selen\Schema\Exchange\Define $define */
            foreach ($defines as $define) {
                if ($define->nestedTypeDefineExists()) {
                    // ネストされた定義なら再帰処理を行う
                    $input[$define->key->getName()] = $this->routine(
                        $input[$define->key->getName()],
                        $define->arrayDefine
                    );
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
                        $input[$define->key->getName()] = $addKeyDefaultValue;
                    }

                    if ($define->key->isRenameKey()) {
                        $beforeName = $define->key->getName();
                        $afterName = $this->keyExchange(
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
                        foreach ($define->executes as $execute) {
                            $input[$define->key->getName()] =
                                $this->valueExchange($execute, $input[$define->key->getName()]);
                        }
                        continue;
                    }

                    if ($define->isIndexArrayDefine()) {
                        // key定義なしのときの処理
                        foreach ($define->executes as $execute) {
                            $input = $this->valueExchange($execute, $input);
                        }
                        continue;
                    }
                }
            }
        }

        if (!$this->isExchanges()) {
            // 全体の変換処理が定義されていないなら入力値をそのまま返す
            return $input;
        }

        // 全体の変換処理が定義されているなら入力側のループ処理を行う
        foreach ($input as $key => $value) {
            if ($this->isKeyExchanges()) {
                $beforeName = $key;
                $afterName = $this->keyExchange(
                    $this->keyExchangesExecute,
                    $beforeName
                );
                $tmpValue = $input[$beforeName];
                unset($input[$beforeName]);
                $input[$afterName] = $tmpValue;
                $key = $afterName;
            }

            if ($this->isValueExchanges()) {
                $input[$key] = $this->valueExchange(
                    $this->valueExchangesExecute,
                    $input[$key]
                );
            }

            if (\is_array($value)) {
                // 値が配列なら再帰処理を行う
                $input[$key] = $this->routine(
                    $input[$key],
                    $arrayDefine
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
     * @param string $key
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
     * @param mixed $value
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
