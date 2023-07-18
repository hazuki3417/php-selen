<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator\Attributes;

use Attribute;
use Selen\Data\Enum;
use Selen\MongoDB\Validator\Model\ValidateResult;
use Selen\MongoDB\Validator\ValueValidateInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayEnum implements ValueValidateInterface
{
    /** @var array<int,string|int|float|bool|null> */
    private $allowValues;

    public function __construct(string|int|float|bool|null ...$values)
    {
        $this->allowValues = $values;
    }

    public function execute($values, ValidateResult $result): ValidateResult
    {
        $viewValues = [];

        foreach ($this->allowValues as $allowValue) {
            $viewValues[] = $this->surround($allowValue);
        }

        $format = 'Invalid type. expected array element type %s.';
        $mes    = \sprintf($format, \implode(', ', $viewValues));

        if (!\is_array($values)) {
            return $result->setResult(false)->setMessage($mes);
        }

        foreach ($values as $value) {
            if (!Enum::validate($value, ...$this->allowValues)) {
                return $result->setResult(false)->setMessage($mes);
            }
        }

        return $result->setResult(true);
    }

    public function surround($value)
    {
        /**
         * NOTE: 表示用に値を整形。
         */
        if (\is_string($value)) {
            return "'{$value}'";
        }

        if (\is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (\is_null($value)) {
            return 'null';
        }
        return $value;
    }
}
