<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB;

use ReflectionClass;
use Selen\MongoDB\Attribute\SchemaLoader;
use Selen\MongoDB\Builder\InsertSchema;
use Selen\MongoDB\Builder\UpdateSchema;

class SchemaBuilder
{
    /** @var string */
    public $schemaClassName;
    /** @var InsertSchema */
    public $insert;
    /** @var UpdateSchema */
    public $update;

    public function __construct(string $schemaClassName)
    {
        $this->schemaClassName = $schemaClassName;
        $schemaLoader          = new SchemaLoader(new ReflectionClass($schemaClassName));
        $this->insert          = new InsertSchema($schemaLoader);
        $this->update          = new UpdateSchema($schemaLoader);
    }
}
