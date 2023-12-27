<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\PSR4\Generator;

use Selen\PSR4\Constants;
use Selen\PSR4\Generator\Result\NamespaceResult;
use Selen\PSR4\Generator\Result\PathResult;
use Selen\PSR4\Map;

/**
 * 名前空間からパスを生成するクラスです
 */
class PathGenerator implements Constants
{
    /**
     * @var Map[] 名前空間のprefixとbase directoryのマッピング情報
     */
    private readonly array $maps;

    public function __construct(Map ...$maps)
    {
        $this->maps = $maps;
    }

    public function execute(string $namespace)
    {
        $conversionChar = $namespace;

        // マッピング情報に基づいてパスを置換
        foreach ($this->maps as $map) {
            /**
             * NOTE: 一番最初にマッチしたものを使う。
             *       複数マッチするケースがある場合は引数の指定順を工夫すること。
             */
            if ($map->matchNamespacePrefix($conversionChar)) {
                $conversionChar = \str_replace(
                    $map->namespacePrefix,
                    $map->baseDirectory,
                    $conversionChar
                );
                break;
            }
        }

        // 区切り文字を置換（namespace -> path）
        $conversionChar = \str_replace(self::DELIMITER_NAMESPACE, self::DELIMITER_PATH, $conversionChar);

        // 拡張子を追加
        $path = $conversionChar . self::EXTENSION_PHP;

        // 区切り文字で単語に分割（名前空間）
        $words = \explode(self::DELIMITER_NAMESPACE, $namespace);

        $namespace = new NamespaceResult(
            $namespace,
            \implode(self::DELIMITER_NAMESPACE, \array_slice($words, 0, -1)),
            \array_slice($words, -1)[0],
        );

        $path = new PathResult(
            $path,
            \dirname($path),
            \basename($path),
        );
        return new Result($namespace, $path);
    }
}
