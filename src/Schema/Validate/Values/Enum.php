<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Values;

use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

class Enum implements ValueValidateInterface
{
    /** @var string */
    protected $messageFormat = 'Invalid value. Expected value %s.';

    /** @var string[] */
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

        $mes = \sprintf($this->messageFormat, \implode(', ', $this->allowValues));
        return $result->setResult(false)->setMessage($mes);
    }

    private function surround($value)
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
