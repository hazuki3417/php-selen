<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator\Attributes;

use Attribute;
use Selen\MongoDB\Validator\Model\ValidateResult;
use Selen\MongoDB\Validator\ValueValidateInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Regex implements ValueValidateInterface
{
    /** @var string */
    protected $messageFormat = 'Invalid value. expected value %s.';

    /** @var string */
    protected $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * 検証を実行します
     *
     * @param mixed          $value  検証する値を渡します
     * @param ValidateResult $result 検証結果を格納するオブジェクトを渡します
     */
    public function execute($value, ValidateResult $result): ValidateResult
    {
        // NOTE: string型以外が来たときはバリデーションを行わない
        if (!\is_string($value)) {
            $mes = 'Skip validation. Executed only when the value is of string type';
            return $result->setResult(true)->setMessage($mes);
        }

        if (!\preg_match("/{$this->pattern}/", $value)) {
            $mes = \sprintf($this->messageFormat, $this->pattern);
            return $result->setResult(false)->setMessage($mes);
        }
        return $result->setResult(true);
    }
}
