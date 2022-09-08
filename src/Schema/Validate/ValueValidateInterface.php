<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate;

use Selen\Schema\Validate\Model\ValidateResult;

interface ValueValidateInterface
{
    public function execute($value, ValidateResult $result): ValidateResult;
}
