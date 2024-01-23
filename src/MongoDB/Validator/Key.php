<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator;

use Selen\Data\ArrayPath;
use Selen\MongoDB\Validator\Model\ValidateResult;
use Selen\MongoDB\Validator\Model\ValidatorResult;

class Key
{
    /** @var ArrayPath */
    private $arrayPath;

    public function __construct(ArrayPath $arrayPath)
    {
        $this->arrayPath = $arrayPath;
    }

    public function execute(string $key, array $input): ValidatorResult
    {
        $this->arrayPath->setCurrentPath($key);

        if (\array_key_exists($key, $input)) {
            return new ValidatorResult();
        }

        $validateResult = new ValidateResult(
            false,
            ArrayPath::toString($this->arrayPath->getPaths()),
            'field is required.'
        );

        return new ValidatorResult($validateResult);
    }
}
