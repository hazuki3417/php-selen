<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Attributes;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\SchemaField;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Attributes\SchemaField
 *
 * @see \Selen\MongoDB\Attributes\SchemaField
 *
 * @internal
 */
class SchemaFieldTest extends TestCase
{
    public function dataProviderConstruct()
    {
        return [
            'pattern001' => [
                'expected' => [
                    'instanceOf' => SchemaField::class,
                ],
                'input' => [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderConstruct
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testConstruct($expected, $input)
    {
        [
            'instanceOf' => $expectedInstanceOf,
        ] = $expected;

        $instance = new SchemaField();

        $this->assertInstanceOf($expectedInstanceOf, $instance);
    }
}
