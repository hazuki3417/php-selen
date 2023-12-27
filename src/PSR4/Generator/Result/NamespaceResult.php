<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\PSR4\Generator\Result;

/**
 * 名前空間の情報を保持するクラスです
 */
class NamespaceResult
{
    /** @var string 名前空間のフルパス */
    public readonly string $full;
    /** @var string 名前空間のベースパス */
    public readonly string $base;
    /** @var string クラス名 */
    public readonly string $class;

    /**
     * 新しいオブジェクトを作成します
     *
     * @param string $full 名前空間のフルパスを指定します
     * @param string $base 名前空間のベースパスを指定します
     * @param string $class クラス名を指定します
     */
    public function __construct(string $full, string $base, string $class)
    {
        $this->full  = $full;
        $this->base  = $base;
        $this->class = $class;
    }
}
