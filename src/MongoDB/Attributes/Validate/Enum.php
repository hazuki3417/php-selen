<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes\Validate;

use Attribute;
use Selen\MongoDB\Validate\Model\ValidateResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Enum implements ValueValidateInterface
{
    /** @var mixed[] */
    private $allowValues;

    public function __construct(...$values)
    {
        $this->allowValues = $values;
    }

    public function execute($value, ValidateResult $result): ValidateResult
    {
        return \in_array($value, $this->allowValues, true) ?
            $result : $result->setResult(false)->setMessage('enum');
    }
}
