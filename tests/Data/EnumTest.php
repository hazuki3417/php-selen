<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Data\Structure;

use DateTime;
use PHPUnit\Framework\TestCase;
use Selen\Data\Enum;
use TypeError;

/**
 * @coversDefaultClass \Selen\Data\Enum
 *
 * @see Enum
 *
 * @internal
 */
class EnumTest extends TestCase
{
    public function dataProviderValidateException()
    {
        return [
            'invalidPattern: 003' => [
                'input' => [
                    'value' => 'valid value',
                    'types' => [[]],
                ],
            ],
            'invalidPattern: 004' => [
                'input' => [
                    'value' => 'valid value',
                    'types' => [new DateTime()],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderValidateException
     *
     * @param mixed $input
     */
    public function testValidateException($input)
    {
        $this->expectException(TypeError::class);
        Enum::validate($input['value'], $input['types']);
    }

    public function dataProviderValidate()
    {
        return [
            'validPattern: 001' => [
                'expected' => true,
                'input'    => [
                    'value' => 'string',
                    'types' => ['string'],
                ],
            ],
            'validPattern: 002' => [
                'expected' => true,
                'input'    => [
                    'value' => 1,
                    'types' => [1],
                ],
            ],
            'validPattern: 003' => [
                'expected' => true,
                'input'    => [
                    'value' => 1.5,
                    'types' => [1.5],
                ],
            ],
            'validPattern: 004' => [
                'expected' => true,
                'input'    => [
                    'value' => true,
                    'types' => [true],
                ],
            ],
            'validPattern: 005' => [
                'expected' => true,
                'input'    => [
                    'value' => null,
                    'types' => [null],
                ],
            ],
            'validPattern: 006' => [
                'expected' => true,
                'input'    => [
                    'value' => null,
                    'types' => [null, 'string'],
                ],
            ],
            'validPattern: 007' => [
                'expected' => true,
                'input'    => [
                    'value' => 'string',
                    'types' => [null, 'string'],
                ],
            ],

            'invalidPattern: 001' => [
                // value = [] は許容していないため常にfalseとなる
                'expected' => false,
                'input'    => [
                    'value' => [],
                    'types' => [],
                ],
            ],
            'invalidPattern: 002' => [
                // value = object は許容していないため常にfalseとなる
                'expected' => false,
                'input'    => [
                    'value' => new DateTime(),
                    'types' => [],
                ],
            ],

            'invalidPattern: 003' => [
                'expected' => false,
                'input'    => [
                    'value' => 'not match string',
                    'types' => ['string'],
                ],
            ],
            'invalidPattern: 004' => [
                'expected' => false,
                'input'    => [
                    'value' => 1.0,
                    'types' => [1],
                ],
            ],
            'invalidPattern: 005' => [
                'expected' => false,
                'input'    => [
                    'value' => 1,
                    'types' => [1.5],
                ],
            ],
            'invalidPattern: 006' => [
                'expected' => false,
                'input'    => [
                    'value' => false,
                    'types' => [true],
                ],
            ],
            'invalidPattern: 007' => [
                'expected' => false,
                'input'    => [
                    'value' => 'not match value',
                    'types' => [null],
                ],
            ],
            'invalidPattern: 008' => [
                'expected' => false,
                'input'    => [
                    'value' => 'not match value',
                    'types' => [true, 'string'],
                ],
            ],
            'invalidPattern: 009' => [
                'expected' => false,
                'input'    => [
                    'value' => false,
                    'types' => [true, 'string'],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderValidate
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testValidate($expected, $input)
    {
        $this->assertSame(
            $expected,
            Enum::validate($input['value'], ...$input['types'])
        );
    }
}
