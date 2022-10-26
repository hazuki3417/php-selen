<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes;

use Attribute;
use Selen\MongoDB\Attribute\SchemaFieldMarkerInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class SchemaField implements SchemaFieldMarkerInterface
{
}
