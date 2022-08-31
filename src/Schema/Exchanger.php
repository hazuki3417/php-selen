<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema;

use Selen\Schema\Exchange\ArrayDefine;
use Selen\Schema\Exchange\ValueExchangeInterface;

/**
 * TODO: key名の変換・追加・削除wを行う機能を追加
 */
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
                $input[$define->key->name()] = self::execute(
                    $input[$define->key->name()],
                    $define->arrayDefine
                );
                continue;
            }

            // ネストされていない定義なら変換処理を行う

            if ($define->isAssocArrayDefine()) {
                // key定義ありのときの処理
                foreach ($define->executes as $execute) {
                    $input[$define->key->name()] =
                        self::exchange($execute, $input[$define->key->name()]);
                }
                continue;
            }

            if ($define->isIndexArrayDefine()) {
                // key定義なしのときの処理
                foreach ($define->executes as $execute) {
                    $input = self::exchange($execute, $input);
                }
                continue;
            }
        }
        return $input;
    }

    /**
     * 値の変換処理を行います
     *
     * @param \Selen\Schema\Exchange\ValueExchangeInterface|callable $execute
     * @param mixed $execute
     * @param mixed $value
     *
     * @return mixed
     */
    private static function exchange($execute, $value)
    {
        if ($execute instanceof ValueExchangeInterface) {
            return $execute->execute($value);
        }

        return $execute($value);
    }
}
