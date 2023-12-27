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
 * パスから名前空間を生成するクラスです
 */
class NamespaceGenerator implements Constants
{
    /**
     * @var Map[] 名前空間のprefixとbase directoryのマッピング情報
     */
    private readonly array $maps;

    public function __construct(Map ...$maps)
    {
        $this->maps = $maps;
    }

    public function execute(string $path)
    {
        $conversionChar = $path;

        // マッピング情報に基づいてパスを置換
        foreach ($this->maps as $map) {
            /**
             * NOTE: 一番最初にマッチしたものを使う。
             *       複数マッチするケースがある場合は引数の指定順を工夫すること。
             */
            if ($map->matchBaseDirectory($conversionChar)) {
                $conversionChar = \str_replace(
                    $map->baseDirectory,
                    $map->namespacePrefix,
                    $conversionChar
                );
                break;
            }
        }

        // 拡張子を除いた名前空間に置換
        $conversionChar = \str_replace(self::EXTENSION_PHP, '', $conversionChar);

        // 区切り文字を置換（path -> namespace）
        $conversionChar = \str_replace(self::DELIMITER_PATH, self::DELIMITER_NAMESPACE, $conversionChar);

        // 区切り文字で単語に分割（名前空間）
        $words = \explode(self::DELIMITER_NAMESPACE, $conversionChar);

        $namespace = new NamespaceResult(
            \implode(self::DELIMITER_NAMESPACE, $words),
            \implode(self::DELIMITER_NAMESPACE, \array_slice($words, 0, -1)),
            \array_slice($words, -1)[0]
        );

        $path = new PathResult(
            $path,
            \dirname($path),
            \basename($path)
        );
        return new Result($namespace, $path);
    }
}
