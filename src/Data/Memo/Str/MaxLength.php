<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Memo\Str;

use Selen\Data\AbstractMemo;

/**
 * 文字列長が最大となる文字列を保持するクラス
 */
class MaxLength extends AbstractMemo
{
    /**
     * 値を保持する条件を満たしているか判定します
     *
     * @param string $object
     *
     * @return bool 条件に一致している場合はtrueを、それ以外の場合はfalseを返します
     */
    protected function condition($object): bool
    {
        if ($this->object === null) {
            $this->object = $object;
            return true;
        }

        /** @var string $org */
        $org = $this->object;
        // TODO: オプションを受け取って細かい挙動を設定できるようにする
        //       オプションはコンストラクタで受け取る想定
        return \mb_strlen($org) < \mb_strlen($object);
    }

    /**
     * 保持する値のデータ型を指定します
     *
     * @return string データ型の名称を返します
     */
    protected function typeName(): string
    {
        return 'string';
    }
}
