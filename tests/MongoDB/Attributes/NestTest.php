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
use Selen\MongoDB\Attributes\Nest;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Attributes\Nest
 *
 * @group Selen
 * @group Selen/MongoDB
 * @group Selen/MongoDB/Attributes
 * @group Selen/MongoDB/Attributes/Nest
 *
 * @see \Selen\MongoDB\Attributes\Nest
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Nest
 *
 * @internal
 */
class NestTest extends TestCase
{
    public function dataProviderConstruct()
    {
        return [
            'pattern001' => [
                'expected' => [
                    'instanceOf'      => Nest::class,
                    'type'            => Nest::TYPE_OBJECT,
                    'schemaClassName' => 'schemaClassName',
                ],
                'input' => [
                    'type'            => Nest::TYPE_OBJECT,
                    'schemaClassName' => 'schemaClassName',
                ],
            ],
            'pattern002' => [
                'expected' => [
                    'instanceOf'      => Nest::class,
                    'type'            => Nest::TYPE_ARRAY_OBJECT,
                    'schemaClassName' => 'schemaClassName',
                ],
                'input' => [
                    'type'            => Nest::TYPE_ARRAY_OBJECT,
                    'schemaClassName' => 'schemaClassName',
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
            'type'            => $type,
            'schemaClassName' => $schemaClassName,
        ] = $input;

        [
            'instanceOf'      => $expectedInstanceOf,
            'type'            => $expectedType,
            'schemaClassName' => $expectedSchemaClassName,
        ] = $expected;

        $instance = new Nest($type, $schemaClassName);

        $this->assertInstanceOf($expectedInstanceOf, $instance);
        $this->assertSame($expectedType, $instance->type);
        $this->assertSame($expectedSchemaClassName, $instance->schemaClassName);
    }

    public function dataProviderConstructException()
    {
        return [
            'pattern001' => [
                'expected' => LogicException::class,
                'input'    => [
                    'type'            => 'type',
                    'schemaClassName' => 'schemaClassName',
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
            'type'            => $type,
            'schemaClassName' => $schemaClassName,
        ] = $input;

        $this->expectException($expected);
        new Nest($type, $schemaClassName);
    }
}
