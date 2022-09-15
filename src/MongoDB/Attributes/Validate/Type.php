<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes\Validate;

use Attribute;
use Selen\Data\Types;
use Selen\MongoDB\Validate\Model\ValidateResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Type implements ValueValidateInterface
{
    /** @var string[] */
    private $names;

    public function __construct(string ...$names)
    {
        $this->names = $names;
    }

    public function execute($value, ValidateResult $result): ValidateResult
    {
        if (Types::validate($value, ...$this->names)) {
            return $result;
        }

        $format = 'Invalid type. expected type %s.';
        $mes    = \sprintf($format, \implode(', ', $this->names));
        return $result->setResult(false)->setMessage($mes);
    }
}
