<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator;

use Selen\MongoDB\Validator\Attribute\ValidateMarkerInterface;
use Selen\MongoDB\Validator\Model\ValidateResult;

interface ValueValidateInterface extends ValidateMarkerInterface
{
    public function execute($value, ValidateResult $result): ValidateResult;
}