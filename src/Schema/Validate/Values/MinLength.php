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
 * 文字列の最小文字数をバリデーションするクラス
 */
class MinLength implements ValueValidateInterface
{
    /** @var string */
    protected $messageFormat = 'Invalid value. Please specify a string of at least %s character.';

    /** @var int */
    protected $length;

    /**
     * 新しいインスタンスを構築します
     *
     * @param int $length 最小文字数を指定します
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
        if (!\is_string($value)) {
            $mes = 'Not supported. Validation that can only support string type.';
            throw new LogicException($mes);
        }

        if (\mb_strlen($value) < $this->length) {
            $mes = \sprintf($this->messageFormat, $this->length);
            return $result->setResult(false)->setMessage($mes);
        }
        return $result->setResult(true);
    }
}
