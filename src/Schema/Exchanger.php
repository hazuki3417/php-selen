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
    /**
     * 定義した配列形式に変換します
     *
     * @param array $input 変換する配列を渡します
     * @param ArrayDefine $arrayDefine 変換の定義を渡します
     *
     * @return array 変換した配列を返します
     */
    public static function execute(array $input, ArrayDefine $arrayDefine)
    {
        $defines = $arrayDefine->defines;

        // 定義側のループ処理
        /** @var \Selen\Schema\Exchange\Define $define */
        foreach ($defines as $define) {
            if ($define->nestedTypeDefineExists()) {
                // ネストされた定義なら再帰処理を行う
                $input[$define->key->getName()] = self::execute(
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
                    $afterName = self::keyExchange(
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
                            self::valueExchange($execute, $input[$define->key->getName()]);
                    }
                    continue;
                }

                if ($define->isIndexArrayDefine()) {
                    // key定義なしのときの処理
                    foreach ($define->executes as $execute) {
                        $input = self::valueExchange($execute, $input);
                    }
                    continue;
                }
            }
        }
        return $input;
    }

    /**
     * keyの変換処理を行います
     *
     * @param \Selen\Schema\Exchange\KeyExchangeInterface|callable|null $execute
     * @param string $key
     *
     * @return string
     */
    private static function keyExchange($execute, $key)
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
     * @param \Selen\Schema\Exchange\ValueExchangeInterface|callable $execute
     * @param mixed $value
     *
     * @return mixed
     */
    private static function valueExchange($execute, $value)
    {
        if ($execute instanceof ValueExchangeInterface) {
            return $execute->execute($value);
        }

        return $execute($value);
    }
}
