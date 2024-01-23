<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate;

use Selen\Schema\Validate\Model\ValidateResult;

interface ValueValidateInterface
{
    /**
     * バリデーションを実行します
     *
     * @param mixed          $value  バリデーション対象の値を渡します
     * @param ValidateResult $result バリデーション結果を格納するインスタンスを渡します
     *
     * @return ValidateResult バリデーション結果を返します
     */
    public function execute($value, ValidateResult $result): ValidateResult;
}
