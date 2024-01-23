<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\PSR4\Generator;

use PHPUnit\Framework\TestCase;
use Selen\PSR4\Generator\NamespaceGenerator;
use Selen\PSR4\Generator\Result;
use Selen\PSR4\Generator\Result\NamespaceResult;
use Selen\PSR4\Generator\Result\PathResult;
use Selen\PSR4\Map;

/**
 * @coversDefaultClass \Selen\PSR4\Generator\NamespaceGenerator
 *
 * @see NamespaceGenerator
 *
 * @internal
 */
class NamespaceGeneratorTest extends TestCase
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
                    'instance'  => NamespaceGenerator::class,
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

        $actual = new NamespaceGenerator(...$maps);
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
                        '$instance->namespace->full'  => 'Selen\\PSR4\\Generator\\NamespaceGenerator',
                        '$instance->namespace->base'  => 'Selen\\PSR4\\Generator',
                        '$instance->namespace->class' => 'NamespaceGenerator',
                        '$instance->path->full'       => 'src/PSR4/Generator/NamespaceGenerator.php',
                        '$instance->path->dir'        => 'src/PSR4/Generator',
                        '$instance->path->file'       => 'NamespaceGenerator.php',
                    ],
                ],
                'input' => [
                    'path' => 'src/PSR4/Generator/NamespaceGenerator.php',
                    'maps' => [
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
            'path' => $path,
            'maps' => $maps,
        ] = $input;

        $instance = new NamespaceGenerator(...$maps);
        $actual   = $instance->execute($path);

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
