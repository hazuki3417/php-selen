<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Attributes;

use LogicException;
use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Schema;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Attributes\Schema
 *
 * @see Schema
 *
 * @internal
 */
class SchemaTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderConstruct(): array
    {
        return [
            'pattern001' => [
                'expected' => [
                    'instanceOf' => Schema::class,
                    'type'       => Schema::TYPE_ROOT,
                ],
                'input' => [
                    'type' => Schema::TYPE_ROOT,
                ],
            ],
            'pattern002' => [
                'expected' => [
                    'instanceOf' => Schema::class,
                    'type'       => Schema::TYPE_INNER,
                ],
                'input' => [
                    'type' => Schema::TYPE_INNER,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderConstruct
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testConstruct($expected, $input): void
    {
        [
            'type' => $type,
        ] = $input;

        [
            'instanceOf' => $expectedInstanceOf,
            'type'       => $expectedType,
        ] = $expected;

        $instance = new Schema($type);

        $this->assertInstanceOf($expectedInstanceOf, $instance);
        $this->assertSame($expectedType, $instance->type);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderConstructException(): array
    {
        return [
            'pattern001' => [
                'expected' => LogicException::class,
                'input'    => [
                    'type' => 'type',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderConstructException
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testConstructException($expected, $input): void
    {
        [
            'type' => $type,
        ] = $input;

        $this->expectException($expected);
        new Schema($type);
    }
}
