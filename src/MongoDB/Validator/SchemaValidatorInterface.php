<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator;

use Selen\MongoDB\Validator\Model\ValidatorResult;

interface SchemaValidatorInterface
{
    /**
     * 値の検証を実行します
     *
     * @param array<mixed,mixed> $input 検証する値を渡します
     */
    public function execute(array $input): ValidatorResult;
}
