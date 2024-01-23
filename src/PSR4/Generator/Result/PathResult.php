<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\PSR4\Generator\Result;

/**
 * ファイルのパスの情報を保持するクラスです
 */
class PathResult
{
    /** @var string ファイルのフルパス */
    public readonly string $full;
    /** @var string ファイルのベースディレクトリ */
    public readonly string $dir;
    /** @var string ファイル名 */
    public readonly string $file;

    /**
     * 新しいオブジェクトを作成します
     *
     * @param string $full ファイルのフルパスを指定します
     * @param string $dir  ファイルのベースディレクトリを指定します
     * @param string $file ファイル名を指定します
     */
    public function __construct(string $full, string $dir, string $file)
    {
        $this->full = $full;
        $this->dir  = $dir;
        $this->file = $file;
    }
}
