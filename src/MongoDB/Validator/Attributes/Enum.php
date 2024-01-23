<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator\Attributes;

use Attribute;
use Selen\Data\Enum as DataEnum;
use Selen\MongoDB\Validator\Model\ValidateResult;
use Selen\MongoDB\Validator\ValueValidateInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Enum implements ValueValidateInterface
{
    /** @var array<int,string|int|float|bool|null> */
    private $allowValues;

    public function __construct(string|int|float|bool|null ...$values)
    {
        $this->allowValues = $values;
    }

    public function execute($value, ValidateResult $result): ValidateResult
    {
        if (DataEnum::validate($value, ...$this->allowValues)) {
            return $result;
        }

        $viewValues = [];

        foreach ($this->allowValues as $allowValue) {
            $viewValues[] = $this->surround($allowValue);
        }

        $format = 'Invalid value. expected value %s.';
        $mes    = \sprintf($format, \implode(', ', $viewValues));
        return $result->setResult(false)->setMessage($mes);
    }

    private function surround(string|float|int|bool|null $value): string
    {
        switch (true) {
            case \is_string($value):
                return \sprintf("'%s'", $value);
            case \is_bool($value):
                return $value ? 'true' : 'false';
            case \is_null($value):
                return 'null';
            default:
                // NOTE: float, intのときは抜ける
                break;
        }
        return \sprintf('%s', $value);
    }
}
