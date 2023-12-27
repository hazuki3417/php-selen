<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

declare(strict_types=1);

namespace Tests\Selen\PSR4\Generator;

use PHPUnit\Framework\TestCase;
use Selen\PSR4\Generator\Result;
use Selen\PSR4\Generator\Result\NamespaceResult;
use Selen\PSR4\Generator\Result\PathResult;

/**
 * @coversDefaultClass \Selen\PSR4\Generator\Result
 *
 * @see Result
 *
 * @internal
 */
class ResultTest extends TestCase
{
    public function dataProviderConstruct()
    {
        return [
            'valid: create instance' => [
                'expected' => [
                    'exception' => null,
                    'instance'  => Result::class,
                ],
                'input' => [
                    'namespace' => new NamespaceResult(
                        'Selen\\PSR4\\Generator\\PathGenerator',
                        'Selen\\PSR4\\Generator',
                        'PathGenerator',
                    ),
                    'path' => new PathResult(
                        'src/PSR4/Generator/PathGenerator.php',
                        'src/PSR4/Generator',
                        'PathGenerator.php'
                    ),
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
            'exception' => $expectedException,
            'instance'  => $exceptedInstance,
        ] = $expected;

        [
            'namespace' => $namespace,
            'path'      => $path,
        ] = $input;

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $actual = new Result($namespace, $path);
        $this->assertInstanceOf($exceptedInstance, $actual);
    }
}
