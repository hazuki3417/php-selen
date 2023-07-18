<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Values;

use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

class Regex implements ValueValidateInterface
{
    /** @var string */
    protected $messageFormat = 'Invalid value. expected value pattern %s.';

    /** @var string */
    private $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

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
