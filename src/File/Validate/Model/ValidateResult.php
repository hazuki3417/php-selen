<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\File\Validate\Model;

class ValidateResult
{
    /** @var bool */
    private $result = true;

    /** @var string */
    private $filePath = '';

    /** @var string */
    private $message = '';

    /**
     * インスタンスを生成します
     *
     * @param bool $result 検証結果を渡します。成功の場合はtrueを、失敗の場合はfalseを設定します
     * @param string $message ファイルパスを渡します
     * @param string $message メッセージを渡します
     */
    public function __construct(bool $result = true, string $filePath = '', string $message = '')
    {
        $this->result   = $result;
        $this->filePath = $filePath;
        $this->message  = $message;
    }

    /**
     * 検証結果を設定します
     *
     * @param bool $value 検証結果を渡します
     */
    public function setResult(bool $value): ValidateResult
    {
        $this->result = $value;
        return $this;
    }

    public function setArrayPath(string $value)
    {
        $this->filePath = $value;
        return $this;
    }

    /**
     * メッセージを設定します
     *
     * @param string $value メッセージ文字列を渡します
     */
    public function setMessage(string $value): ValidateResult
    {
        $this->message = $value;
        return $this;
    }

    /**
     * 検証結果を取得します
     *
     * @return bool 成功の場合はtrueを、失敗の場合はfalseを返します
     */
    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * 配列の階層パスを取得します
     *
     * @return string 配列の階層パスを返します
     */
    public function getArrayPath(): string
    {
        return $this->filePath;
    }

    /**
     * メッセージを取得します
     *
     * @return string メッセージを返します
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
