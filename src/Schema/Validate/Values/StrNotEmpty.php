<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Values;

use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

class StrNotEmpty implements ValueValidateInterface
{
    public function execute($value, ValidateResult $result): ValidateResult
    {
        if (!\is_string($value)) {
            $mes = 'Skip validation. Executed only when the value is of string type.';
            return $result->setResult(true)->setMessage($mes);
        }

        if (empty($value)) {
            $mes = 'Invalid value. A string of at least 1 character is required.';
            return $result->setResult(false)->setMessage($mes);
        }

        return $result->setResult(true);
    }
}
