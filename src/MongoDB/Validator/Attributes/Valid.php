<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator\Attributes;

use Attribute;
use Selen\MongoDB\Validator\Attribute\ValidateMarkerInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Valid implements ValidateMarkerInterface
{
}
