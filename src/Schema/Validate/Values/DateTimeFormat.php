<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Values;

use DateTime;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

class DateTimeFormat implements ValueValidateInterface
{
    /** @var string */
    private $format;

    public function __construct(string $format)
    {
        $this->format = $format;
    }

    public function execute($value, ValidateResult $result): ValidateResult
    {
        if (!\is_string($value)) {
            $mes = 'Skip validation. Executed only when the value is of string type.';
            return $result->setResult(true)->setMessage($mes);
        }

        $dateTime = DateTime::createFromFormat($this->format, $value);

        if ($dateTime === false || $dateTime->format($this->format) !== $value) {
            $mes = \sprintf('Invalid value. expected value format %s.', $this->format);
            return $result->setResult(false)->setMessage($mes);
        }

        return $result->setResult(true);
    }
}
