<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\PSR4\Generator;

use PHPUnit\Framework\TestCase;
use Selen\PSR4\Generator\PathGenerator;
use Selen\PSR4\Generator\Result;
use Selen\PSR4\Generator\Result\NamespaceResult;
use Selen\PSR4\Generator\Result\PathResult;
use Selen\PSR4\Map;

/**
 * @coversDefaultClass \Selen\PSR4\Generator\PathGenerator
 *
 * @see PathGenerator
 *
 * @internal
 */
class PathGeneratorTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderConstruct(): array
    {
        return [
            'valid: create instance' => [
                'expected' => [
                    'exception' => null,
                    'instance'  => PathGenerator::class,
                ],
                'input' => [
                    'maps' => [],
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
            'exception' => $expectedException,
            'instance'  => $exceptedInstance,
        ] = $expected;

        [
            'maps' => $maps,
        ] = $input;

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $actual = new PathGenerator(...$maps);
        $this->assertInstanceOf($exceptedInstance, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderExecute(): array
    {
        return [
            'valid: create instance' => [
                'expected' => [
                    'properties' => [
                        '$instance->namespace->full'  => 'Selen\\PSR4\\Generator\\PathGenerator',
                        '$instance->namespace->base'  => 'Selen\\PSR4\\Generator',
                        '$instance->namespace->class' => 'PathGenerator',
                        '$instance->path->full'       => 'src/PSR4/Generator/PathGenerator.php',
                        '$instance->path->dir'        => 'src/PSR4/Generator',
                        '$instance->path->file'       => 'PathGenerator.php',
                    ],
                ],
                'input' => [
                    'namespace' => 'Selen\\PSR4\\Generator\\PathGenerator',
                    'maps'      => [
                        new Map('Selen\\', 'src/'),
                        new Map('Tests\\Selen\\', 'tests/'),
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testExecute($expected, $input): void
    {
        [
            'properties' => $expectedProperties,
        ] = $expected;

        [
            'namespace' => $namespace,
            'maps'      => $maps,
        ] = $input;

        $instance = new PathGenerator(...$maps);
        $actual   = $instance->execute($namespace);

        $this->assertInstanceOf(Result::class, $actual);

        $this->assertInstanceOf(NamespaceResult::class, $actual->namespace);
        $this->assertInstanceOf(PathResult::class, $actual->path);

        $this->assertSame($expectedProperties, [
            '$instance->namespace->full'  => $actual->namespace->full,
            '$instance->namespace->base'  => $actual->namespace->base,
            '$instance->namespace->class' => $actual->namespace->class,
            '$instance->path->full'       => $actual->path->full,
            '$instance->path->dir'        => $actual->path->dir,
            '$instance->path->file'       => $actual->path->file,
        ]);
    }
}
