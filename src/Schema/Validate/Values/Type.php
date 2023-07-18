<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Values;

use Selen\Data\Types;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\ValueValidateInterface;

class Type implements ValueValidateInterface
{
    /** @var string */
    protected $messageFormat = 'Invalid type. expected type %s.';

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

        $mes = \sprintf($this->messageFormat, \implode(', ', $this->names));
        return $result->setResult(false)->setMessage($mes);
    }
}
