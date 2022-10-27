<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator\Attributes;

use Attribute;
use Selen\Data\ArrayTypes;
use Selen\MongoDB\Validator\Model\ValidateResult;
use Selen\MongoDB\Validator\ValueValidateInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayType implements ValueValidateInterface
{
    /** @var string[] */
    private $names;

    public function __construct(string ...$names)
    {
        $this->names = $names;
    }

    public function execute($value, ValidateResult $result): ValidateResult
    {
        $format = 'Invalid type. expected array element type %s.';
        $mes    = \sprintf($format, \implode(', ', $this->names));

        if (!\is_array($value)) {
            return $result->setResult(false)->setMessage($mes);
        }

        if (!ArrayTypes::validate($value, ...$this->names)) {
            return $result->setResult(false)->setMessage($mes);
        }
        return $result->setResult(true);
    }
}
