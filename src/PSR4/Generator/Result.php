<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\PSR4\Generator;

use Selen\PSR4\Generator\Result\NamespaceResult;
use Selen\PSR4\Generator\Result\PathResult;

/**
 * 名前空間とファイルパスの情報を保持するクラスです
 */
class Result
{
    /** @var NamespaceResult インスタンス */
    public readonly NamespaceResult $namespace;
    /** @var PathResult インスタンス */
    public readonly PathResult $path;

    /**
     * 新しいオブジェクトを作成します
     *
     * @param NamespaceResult $namespace インスタンスを指定します
     * @param PathResult $path インスタンスを指定します
     */
    public function __construct(NamespaceResult $namespace, PathResult $path)
    {
        $this->namespace = $namespace;
        $this->path      = $path;
    }
}
