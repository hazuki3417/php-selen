<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2024 hazuki3417 all rights reserved.
 */

namespace Selen\Str;

/**
 * Byte Order Markに関する処理を提供するクラス
 */
class Bom
{
    /**
     * NOTE: 文字コードでBOM文字を作成。正規表現パターンではないので注意。
     */

    /** @var string UTF-8のBOM文字列 */
    public const UTF_8 = '\xEF\xBB\xBF';

    /**
     * 文字列にByte Order Markが存在するか確認します
     *
     * @param string $value 文字列を渡します
     *
     * @return bool 存在する場合はtrueを、それ以外の場合はfalseを返します
     */
    public static function exists(string $value): bool
    {
        $bom = self::UTF_8;
        return preg_match("/{$bom}/", $value);
    }

    /**
     * 文字列からByte Order Markを除去します
     *
     * @param string $value 文字列を渡します
     *
     * @return string BOM文字を除去した文字列を返します
     */
    public static function remove(string $value): string
    {
        $bom        = self::UTF_8;
        $replaceStr = '';
        return preg_replace("/{$bom}/", $replaceStr, $value);
    }
}
