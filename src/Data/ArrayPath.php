<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

class ArrayPath
{
    private static string $separator = '.';

    /** @var string[] */
    private array $paths = [];

    /** @var int 階層の深さ */
    private int $currentIndex = 0;

    private int $minCurrentIndex = 0;

    /**
     * 現在位置から1つ上の階層に移動します
     *
     * @return bool 成功した場合はtrueを、それ以外の場合はfalseを返します
     */
    public function up(): bool
    {
        if ($this->currentIndex <= $this->minCurrentIndex) {
            return false;
        }
        unset($this->paths[$this->currentIndex]);
        --$this->currentIndex;
        return true;
    }

    /**
     * 現在位置から1つ下の階層に移動します
     *
     * @return bool 常にtrueを返します
     */
    public function down(): bool
    {
        ++$this->currentIndex;

        if (!isset($this->paths[$this->currentIndex])) {
            $this->paths[$this->currentIndex] = '';
        }

        return true;
    }

    /**
     * key名を設定します
     *
     * @param string $name key名を渡します
     *
     * @return bool 成功した場合はtrueを、それ以外の場合はfalseを返します
     */
    public function setCurrentPath(string $name)
    {
        if ($this->currentIndex <= $this->minCurrentIndex) {
            return false;
        }
        $this->paths[$this->currentIndex] = $name;
        return true;
    }

    /**
     * 配列の階層情報を取得します。
     *
     * @return string[] 配列の階層情報を返します
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * 現在位置の階層を取得します
     *
     * @return int 現在位置の階層を返します
     */
    public function getCurrentIndex(): int
    {
        return $this->currentIndex;
    }

    /**
     * 配列形式の階層表現を文字列形式に変換します
     *
     * @param string[] $paths 配列形式の階層表現配列を渡します
     *
     * @return string 文字列形式の階層表現文字列を返します
     */
    public static function toString(array $paths): string
    {
        return \implode(self::$separator, $paths);
    }

    /**
     * 文字列形式の階層表現を配列形式に変換します
     *
     * @param string $path 文字列形式の階層表現文字列を渡します
     *
     * @return string[] 配列形式の階層表現配列を返します
     */
    public static function toArray(string $path): array
    {
        if ($path === '') {
            return [];
        }
        return \explode(self::$separator, $path);
    }
}
