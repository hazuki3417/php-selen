<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\PSR4;

/**
 * 名前空間のnamespace prefixとbase directoryのマッピング情報を保持するクラスです
 */
class Map implements Constants
{
    /**
     * @var string 名前空間のprefix
     */
    public readonly string $namespacePrefix;

    /**
     * @var string 名前空間のprefixに対応するbase directory
     */
    public readonly string $baseDirectory;

    public function __construct(string $namespacePrefix, string $baseDirectory)
    {
        // 先頭または末尾にある区切り文字を除去（記載揺れの対応）
        $this->namespacePrefix = \trim($namespacePrefix, self::DELIMITER_NAMESPACE);
        $this->baseDirectory   = \trim($baseDirectory, self::DELIMITER_PATH);
    }

    public function matchNamespacePrefix(string $namespace): bool
    {
        return strpos($namespace, $this->namespacePrefix) === 0;
    }

    public function matchBaseDirectory(string $path): bool
    {
        return strpos($path, $this->baseDirectory) === 0;
    }
}
