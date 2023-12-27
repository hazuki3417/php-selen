<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\PSR4;

/**
 * 定数を提供するインターフェースです
 */
interface Constants
{
    /**
     * @var string 名前空間の区切り文字
     */
    public const DELIMITER_NAMESPACE = '\\';

    /**
     * @var string パスの区切り文字
     */
    public const DELIMITER_PATH = '/';

    /**
     * @var string パスの拡張子
     */
    public const EXTENSION_PHP = '.php';
}
