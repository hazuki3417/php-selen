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

    /** @var bool 空文字の許容ステータスを保持します（true: 許容する, false: 許容しない） */
    private bool $allowEmpty;

    /**
     * @param string $format     日付フォーマットを指定します
     * @param bool   $allowEmpty 空文字を許容するか指定します。（true: 許容する, false: 許容しない）
     */
    public function __construct(string $format, bool $allowEmpty = false)
    {
        $this->format = $format;

        $this->allowEmpty = $allowEmpty;
    }

    public function execute($value, ValidateResult $result): ValidateResult
    {
        if (!\is_string($value)) {
            $mes = 'Skip validation. Executed only when the value is of string type.';
            return $result->setResult(true)->setMessage($mes);
        }

        if ($this->allowEmpty && $value === '') {
            return $result->setResult(true);
        }

        $dateTime = DateTime::createFromFormat($this->format, $value);

        if ($dateTime === false || $dateTime->format($this->format) !== $value) {
            $mes = \sprintf('Invalid value. Expected value format %s.', $this->format);
            return $result->setResult(false)->setMessage($mes);
        }

        return $result->setResult(true);
    }
}
