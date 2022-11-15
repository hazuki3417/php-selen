<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Values;

use LogicException;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

/**
 * 文字列の最大文字数をバリデーションするクラス
 */
class MaxLength implements ValueValidateInterface
{
    /** @var string */
    protected $messageFormat = 'Invalid value. Please specify with a character string of %s characters or less.';

    /** @var int */
    protected $length;

    /**
     * 新しいインスタンスを構築します
     *
     * @param int $length 最大文字数を指定します
     */
    public function __construct(int $length)
    {
        if ($length < 0) {
            $mes = 'Invalid value. Values less than 0 cannot be specified.';
            throw new LogicException($mes);
        }
        $this->length = $length;
    }

    /**
     * {@inheritDoc}
     */
    public function execute($value, ValidateResult $result): ValidateResult
    {
        // NOTE: string型以外が来たときはバリデーションを行わない
        if (!\is_string($value)) {
            $mes = 'Skip validation. Executed only when the value is of string type';
            return $result->setResult(true)->setMessage($mes);
        }

        if ($this->length < \mb_strlen($value)) {
            $mes = \sprintf($this->messageFormat, $this->length);
            return $result->setResult(false)->setMessage($mes);
        }
        return $result->setResult(true);
    }
}
