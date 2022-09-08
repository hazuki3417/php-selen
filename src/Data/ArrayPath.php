<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

class ArrayPath
{
    /** @var string */
    private static $separator = '.';

    /** @var string[] */
    private $paths = [];

    /** @var int */
    private $currentIndex = 0;

    /**
     * 現在位置から1つ上の階層に移動します
     *
     * @return bool 成功した場合はtrueを、それ以外の場合はfalseを返します
     */
    public function up(): bool
    {
        if ($this->currentIndex <= 0) {
            return false;
        }
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
     * key名を設定します。key名はcurrent()が返す階層に設定されます
     *
     * @param string $pathName key名を渡します
     */
    public function set(string $pathName)
    {
        $this->paths[$this->current()] = $pathName;
    }

    /**
     * 指定した範囲のkey名を取得します
     *
     * @param int $start 取得する階層の開始位置を渡します
     * @param int $end 取得する階層の終了位置を渡します
     *
     * @return array 指定した範囲のkey名を返します
     */
    public function fetch(int $start, int $end): array
    {
        if ($start < 0) {
            throw new \ValueError('Invalid value range for $start.');
        }

        if (count($this->paths) < $end) {
            throw new \ValueError('Invalid value range for $end.');
        }

        if ($end < $start) {
            throw new \ValueError('Invalid value range. Please specify a value smaller than $end for $start.');
        }

        $length = ($end - $start) + 1;

        return \array_slice($this->paths, $start, $length);
    }

    /**
     * 現在位置の階層を取得します
     *
     * @return int 現在位置の階層を返します
     */
    public function current(): int
    {
        return $this->currentIndex;
    }

    /**
     *配列形式の階層表現を文字列形式に変換します
     *
     * @param array $paths 配列形式の階層表現配列を渡します
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
     * @return array 配列形式の階層表現配列を返します
     */
    public static function toArray(string $path): array
    {
        if ($path === '') {
            return [];
        }
        return \explode(self::$separator, $path);
    }
}
