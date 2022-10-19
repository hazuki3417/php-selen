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
 * 配列の最大要素数をバリデーションするクラス
 */
class MaxSize implements ValueValidateInterface
{
    /** @var string */
    protected $messageFormat = 'Invalid value. Specify an array with %s or less elements.';

    /** @var int */
    protected $size;

    /**
     * 新しいインスタンスを構築します
     *
     * @param int $length 最大要素数を指定します
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
        if (!\is_array($value)) {
            $mes = 'Not supported. Validation that can only support array type.';
            throw new LogicException($mes);
        }

        if ($this->size < \count($value)) {
            $mes = \sprintf($this->messageFormat, $this->size);
            return $result->setResult(false)->setMessage($mes);
        }
        return $result->setResult(true);
    }
}
