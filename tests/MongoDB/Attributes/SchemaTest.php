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
 * @group Selen
 * @group Selen/MongoDB
 * @group Selen/MongoDB/Attributes
 * @group Selen/MongoDB/Attributes/Schema
 *
 * @see \Selen\MongoDB\Attributes\Schema
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Schema
 *
 * @internal
 */
class SchemaTest extends TestCase
{
    public function dataProviderConstruct()
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
    public function testConstruct($expected, $input)
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

    public function dataProviderConstructException()
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
    public function testConstructException($expected, $input)
    {
        [
            'type' => $type,
        ] = $input;

        $this->expectException($expected);
        new Schema($type);
    }
}
