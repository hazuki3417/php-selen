<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\PSR4;

use PHPUnit\Framework\TestCase;
use Selen\PSR4\Map;

/**
 * @coversDefaultClass \Selen\PSR4\Map
 *
 * @see Map
 *
 * @internal
 */
class MapTest extends TestCase
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
                    'instance'  => Map::class,
                ],
                'input' => [
                    'args' => [
                        'namespacePrefix' => '',
                        'baseDirectory'   => '',
                    ],
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
            'args' => $args,
        ] = $input;

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $actual = new Map(...$args);
        $this->assertInstanceOf($exceptedInstance, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderNamespacePrefix(): array
    {
        return [
            'no match: namespacePrefix is empty string' => [
                'expected' => [
                    'exception' => null,
                    'return'    => false,
                ],
                'input' => [
                    'constructArgs' => [
                        'namespacePrefix' => 'Tests\\Selen\\',
                        'baseDirectory'   => 'tests/',
                    ],
                    'namespace' => '',
                ],
            ],
            'no match: namespacePrefix is \\Tests\\Selen' => [
                'expected' => [
                    'exception' => null,
                    'return'    => false,
                ],
                'input' => [
                    'constructArgs' => [
                        'namespacePrefix' => 'Tests\\Selen\\',
                        'baseDirectory'   => 'tests/',
                    ],
                    'namespace' => '\\Tests\\Selen\\Example\\',
                ],
            ],
            'no match: namespacePrefix is Selen' => [
                'expected' => [
                    'exception' => null,
                    'return'    => false,
                ],
                'input' => [
                    'constructArgs' => [
                        'namespacePrefix' => 'Tests\\Selen\\',
                        'baseDirectory'   => 'tests/',
                    ],
                    'namespace' => 'Selen\\Example\\',
                ],
            ],
            'match: namespacePrefix is Tests\\Selen\\' => [
                'expected' => [
                    'exception' => null,
                    'return'    => true,
                ],
                'input' => [
                    'constructArgs' => [
                        'namespacePrefix' => 'Tests\\Selen\\',
                        'baseDirectory'   => 'tests/',
                    ],
                    'namespace' => 'Tests\\Selen\\Example\\',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderNamespacePrefix
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testNamespacePrefix($expected, $input): void
    {
        [
            'exception' => $expectedException,
            'return'    => $expectedReturn,
        ] = $expected;

        [
            'constructArgs' => $constructArgs,
            'namespace'     => $namespace,
        ] = $input;

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $map    = new Map(...$constructArgs);
        $actual = $map->matchNamespacePrefix($namespace);
        $this->assertSame($expectedReturn, $actual);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderBaseDirectory(): array
    {
        return [
            'no match: baseDirectory is empty string' => [
                'expected' => [
                    'exception' => null,
                    'return'    => false,
                ],
                'input' => [
                    'constructArgs' => [
                        'namespacePrefix' => 'Tests\\Selen\\',
                        'baseDirectory'   => 'tests/',
                    ],
                    'path' => '',
                ],
            ],
            'no match: baseDirectory is /tests/example' => [
                'expected' => [
                    'exception' => null,
                    'return'    => false,
                ],
                'input' => [
                    'constructArgs' => [
                        'namespacePrefix' => 'Tests\\Selen\\',
                        'baseDirectory'   => 'tests/',
                    ],
                    'path' => '/tests/example',
                ],
            ],
            'no match: baseDirectory is ests/example' => [
                'expected' => [
                    'exception' => null,
                    'return'    => false,
                ],
                'input' => [
                    'constructArgs' => [
                        'namespacePrefix' => 'Tests\\Selen\\',
                        'baseDirectory'   => 'tests/',
                    ],
                    'path' => 'ests/example',
                ],
            ],
            'match: baseDirectory is tests/example' => [
                'expected' => [
                    'exception' => null,
                    'return'    => true,
                ],
                'input' => [
                    'constructArgs' => [
                        'namespacePrefix' => 'Tests\\Selen\\',
                        'baseDirectory'   => 'tests/',
                    ],
                    'path' => 'tests/example',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderBaseDirectory
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testBaseDirectory($expected, $input): void
    {
        [
            'exception' => $expectedException,
            'return'    => $expectedReturn,
        ] = $expected;

        [
            'constructArgs' => $constructArgs,
            'path'          => $path,
        ] = $input;

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $map    = new Map(...$constructArgs);
        $actual = $map->matchBaseDirectory($path);
        $this->assertSame($expectedReturn, $actual);
    }
}
