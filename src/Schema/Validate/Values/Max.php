<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Values;

use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

/**
 * 値の最大範囲値をバリデーションするクラス
 */
class Max implements ValueValidateInterface
{
    /** @var string */
    protected $messageFormat = 'Invalid value. Specify a value of %s or less.';

    /** @var float */
    protected $threshold;

    /**
     * 新しいインスタンスを構築します
     *
     * @param int|float $threshold 最大範囲値を指定します
     */
    public function __construct(int|float $threshold)
    {
        $this->threshold = $threshold;
    }

    /**
     * {@inheritDoc}
     */
    public function execute($value, ValidateResult $result): ValidateResult
    {
        $allowType = \is_int($value) || \is_float($value);

        if (!$allowType) {
            $mes = 'Skip validation. Executed only when the value is of type int or float';
            return $result->setResult(true)->setMessage($mes);
        }

        if ($this->threshold < $value) {
            $mes = \sprintf($this->messageFormat, $this->threshold);
            return $result->setResult(false)->setMessage($mes);
        }
        return $result->setResult(true);
    }
}
