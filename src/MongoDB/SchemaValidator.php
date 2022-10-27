<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB;

use ReflectionClass;
use Selen\MongoDB\Attribute\SchemaLoader;
use Selen\MongoDB\Validator\InsertSchema;
use Selen\MongoDB\Validator\UpdateSchema;

class SchemaValidator
{
    /** @var string */
    public $schemaClassName;
    /** @var \Selen\MongoDB\Validator\InsertSchema */
    public $insert;
    /** @var \Selen\MongoDB\Validator\UpdateSchema */
    public $update;

    public function __construct(string $schemaClassName)
    {
        $this->schemaClassName = $schemaClassName;
        $schemaLoader          = new SchemaLoader(new ReflectionClass($schemaClassName));
        $this->insert          = new InsertSchema($schemaLoader);
        $this->update          = new UpdateSchema($schemaLoader);
    }
}
