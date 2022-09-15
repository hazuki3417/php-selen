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
        // TODO: enumに配列やオブジェクトは指定できないように修正する

        if (\in_array($value, $this->allowValues, true)) {
            return $result;
        }

        foreach ($this->allowValues as $index => $allowValue) {
            $this->allowValues[$index] = $this->surround($allowValue);
        }

        $format = 'Invalid value. expected value %s.';
        $mes    = \sprintf($format, \implode(', ', $this->allowValues));
        return $result->setResult(false)->setMessage($mes);
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
