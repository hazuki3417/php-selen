<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes\Validate;

use Selen\MongoDB\Attributes\AttributeMarkerInterface;
use Selen\MongoDB\Validate\Model\ValidateResult;

/**
 * 型チェックのAttributeとして識別するためのインターフェース
 */
interface ValueValidateInterface extends AttributeMarkerInterface
{
    public function execute($value, ValidateResult $result): ValidateResult;
}
