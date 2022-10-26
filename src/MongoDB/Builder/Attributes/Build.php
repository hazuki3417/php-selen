<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Builder\Attributes;

use Attribute;
use Selen\MongoDB\Attribute\AttributeMarkerInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Build implements AttributeMarkerInterface
{
}
