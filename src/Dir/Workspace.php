<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\Dir;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

/**
 * 作業ディレクトリの作成・削除を提供するクラス
 */
class Workspace
{
    /** @var string 作業パス */
    private string $path;

    /**
     * 新しいオブジェクトを作成します
     *
     * @param string $path 作業ディレクトリパスを指定します
     *
     * @return Workspace 新しいオブジェクトを返します
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * 作業ディレクトリを削除します
     */
    public function __destruct()
    {
        $this->remove();
    }

    /**
     * 作業ディレクトリを作成します
     *
     * @param int $permissions 権限を指定します
     */
    public function create(int $permissions = 0777)
    {
        if (\file_exists($this->path)) {
            $mes = \sprintf(
                'Failed to create workspace. %s directory already exists.',
                $this->path
            );
            throw new RuntimeException($mes);
        }

        \mkdir($this->path, $permissions, true);
    }

    /**
     * 作業ディレクトリを削除します
     */
    public function remove()
    {
        if (!\is_dir($this->path)) {
            return;
        }

        $iterator = new RecursiveDirectoryIterator(
            $this->path,
            RecursiveDirectoryIterator::SKIP_DOTS
        );
        $files = new RecursiveIteratorIterator(
            $iterator,
            RecursiveIteratorIterator::CHILD_FIRST
        );

        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            $file->isDir() ?
                rmdir($file->getRealPath()) :
                unlink($file->getRealPath());
        }
        rmdir($this->path);
    }

    /**
     * 作業ディレクトリパスを取得します
     *
     * @return string 作業ディレクトリパスを返します
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
