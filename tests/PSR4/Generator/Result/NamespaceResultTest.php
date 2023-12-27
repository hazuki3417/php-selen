<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

declare(strict_types=1);

namespace Tests\Selen\PSR4\Generator\Result;

use PHPUnit\Framework\TestCase;
use Selen\PSR4\Generator\Result\NamespaceResult;

/**
 * @coversDefaultClass \Selen\PSR4\Generator\Result\NamespaceResult
 *
 * @see NamespaceResult
 *
 * @internal
 */
class NamespaceResultTest extends TestCase
{
    public function dataProviderConstruct()
    {
        return [
            'valid: create instance' => [
                'expected' => [
                    'exception' => null,
                    'instance'  => NamespaceResult::class,
                ],
                'input' => [
                    'full'  => 'Selen\\PSR4\\Generator\\PathGenerator',
                    'base'  => 'Selen\\PSR4\\Generator',
                    'class' => 'PathGenerator',
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
            'full'  => $full,
            'base'  => $base,
            'class' => $class,
        ] = $input;

        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        $actual = new NamespaceResult($full, $base, $class);
        $this->assertInstanceOf($exceptedInstance, $actual);
    }
}
