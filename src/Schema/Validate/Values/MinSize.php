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
 * 配列の最小要素数をバリデーションするクラス
 */
class MinSize implements ValueValidateInterface
{
    /** @var string */
    protected $messageFormat = 'Invalid value. Please specify an array of %s or more elements.';

    /** @var int */
    protected $size;

    /**
     * 新しいインスタンスを構築します
     *
     * @param int $size 最小要素数を指定します
     */
    public function __construct(int $size)
    {
        if ($size < 0) {
            $mes = 'Invalid value. Values less than 0 cannot be specified.';
            throw new LogicException($mes);
        }
        $this->size = $size;
    }

    /**
     * {@inheritDoc}
     */
    public function execute($value, ValidateResult $result): ValidateResult
    {
        // NOTE: 配列型以外が来たときはバリデーションを行わない
        if (!\is_array($value)) {
            $mes = 'Skip validation. Executed only when the value is of array type';
            return $result->setResult(true)->setMessage($mes);
        }

        if (\count($value) < $this->size) {
            $mes = \sprintf($this->messageFormat, $this->size);
            return $result->setResult(false)->setMessage($mes);
        }
        return $result->setResult(true);
    }
}
