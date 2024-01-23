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
    protected $messageFormat = 'Invalid value. expected value %s.';

    /** @var array<mixed,string|float|int|bool|null> */
    private $allowValues;

    public function __construct(string|float|int|bool|null ...$values)
    {
        $this->allowValues = $values;
    }

    public function execute($value, ValidateResult $result): ValidateResult
    {
        if (\in_array($value, $this->allowValues, true)) {
            return $result;
        }

        foreach ($this->allowValues as $index => $allowValue) {
            $this->allowValues[$index] = $this->surround($allowValue);
        }

        $mes = \sprintf($this->messageFormat, \implode(', ', $this->allowValues));
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
