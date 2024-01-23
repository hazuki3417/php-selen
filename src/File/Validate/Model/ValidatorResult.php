<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\File\Validate\Model;

class ValidatorResult
{
    /** @var bool */
    private $result = true;

    /** @var ValidateResult[] */
    private $validateResults;

    /**
     * インスタンスを生成します
     *
     * @param ValidateResult $validateResults バリデーション結果を渡します
     */
    public function __construct(ValidateResult ...$validateResults)
    {
        $this->validateResults = $validateResults;

        foreach ($this->validateResults as $validateResult) {
            if ($validateResult->getResult() !== true) {
                $this->result = false;
                break;
            }
        }
    }

    /**
     * バリデーションに合格したかどうか確認します
     *
     * @return bool バリデーションに合格した場合はtrueを、それ以外の場合はfalseを返します
     */
    public function success(): bool
    {
        return $this->result === true;
    }

    /**
     * バリデーションに違反したかどうか確認します
     *
     * @return bool バリデーションに違反した場合はtrueを、それ以外の場合はfalseを返します
     */
    public function failure(): bool
    {
        return $this->result === false;
    }

    /**
     * バリデーションの詳細情報を取得します
     *
     * @return ValidateResult[]
     */
    public function getValidateResults()
    {
        return $this->validateResults;
    }
}
