<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Values;

use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

class ArrayNotEmpty implements ValueValidateInterface
{
    public function execute($value, ValidateResult $result): ValidateResult
    {
        if (!\is_array($value)) {
            $mes = 'Skip validation. Executed only when the value is of array type.';
            return $result->setResult(true)->setMessage($mes);
        }

        if (empty($value)) {
            $mes = 'Invalid value. Must have at least one element.';
            return $result->setResult(false)->setMessage($mes);
        }

        return $result->setResult(true);
    }
}
