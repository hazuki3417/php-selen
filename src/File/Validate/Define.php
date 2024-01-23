<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\File\Validate;

use Selen\Str\SizeParser;

/**
 * ファイルバリデーションの設定・検証を提供するクラスです。
 */
class Define
{
    /** @var string|null ファイルサイズ上限 */
    private string|null $limitSize;
    /** @var string[] 許容する拡張子 */
    private array $allowExtensions;

    /**
     * バリデーション定義を作成します。
     *
     * @param string|null $limitSize          ファイルサイズの上限を指定します
     * @param string      ...$allowExtensions 許容する拡張子を指定します。
     */
    private function __construct(string $limitSize = null, string ...$allowExtensions)
    {
        if (\is_string($limitSize)) {
            if (!SizeParser::validParse($limitSize)) {
                throw SizeParser::makeParseException();
            }
        }

        $this->limitSize       = $limitSize;
        $this->allowExtensions = $allowExtensions;
    }

    /**
     * ファイルサイズの上限値（byte）を取得します
     *
     * @return string|null ファイルサイズの上限値を返します
     */
    public function getLimitSize()
    {
        return $this->limitSize;
    }

    /**
     * 許容する拡張子を取得します
     *
     * @return string[] 許容する拡張子を返します
     */
    public function getAllowExtensions()
    {
        return $this->allowExtensions;
    }

    /**
     * バリデーション定義を作成します。
     *
     * @param string|null $limitSize       ファイルサイズの上限を指定します。指定しない場合はnullを指定します。
     * @param string      $allowExtensions 許容する拡張子を指定します
     */
    public static function make(string $limitSize = null, string ...$allowExtensions): Define
    {
        return new self($limitSize, ...$allowExtensions);
    }

    /**
     * 許可されたファイル拡張子かどうか確認します。
     *
     * @param string $filePath ファイルパスを渡します
     *
     * @return bool 許可されたファイル拡張子の場合はtrueを、それ以外の場合はfalseを返します。
     *
     * NOTE: $allowExtensionsを指定しなかった場合（$allowExtensions = []）は常にtrueを返します。
     */
    public function isAllowExtension(string $filePath): bool
    {
        if ($this->allowExtensions === []) {
            return true;
        }

        return \in_array(pathinfo($filePath, PATHINFO_EXTENSION), $this->allowExtensions, true);
    }

    /**
     * 指定されたファイルサイズ上限以下であるか確認します。
     *
     * @param string $filePath ファイルパスを渡します
     *
     * @return bool 指定されたファイルサイズ上限以下であればtrueを、それ以外の場合はfalseを返します。
     *
     * NOTE: $limitSizeを指定しなかった場合（$limitSize = null）は常にtrueを返します。
     */
    public function isUnderSizeLimit(string $filePath): bool
    {
        if ($this->limitSize === null) {
            return true;
        }
        return \filesize($filePath) <= SizeParser::toByte($this->limitSize);
    }
}
