<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\File;

use PHPUnit\Framework\TestCase;
use Selen\File\Validate\Define;
use Selen\File\Validator;

/**
 * @coversDefaultClass \Selen\File\Validator
 * * *
 * @see Validator
 *
 * @internal
 */
class ValidatorTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderExecute(): array
    {
        return [
            'validPattern: 001' => [
                'expected' => true,
                'input'    => [
                    'construct' => [
                        Define::make('5MiB', 'txt'),
                    ],
                    'execute' => [
                        './test-res/File/Validator/5MiB-eq.txt',
                    ],
                ],
            ],
            'invalidPattern: 対応していない拡張子' => [
                'expected' => false,
                'input'    => [
                    'construct' => [
                        Define::make('5MiB', 'doc'),
                    ],
                    'execute' => [
                        './test-res/File/Validator/5MiB-eq.txt',
                    ],
                ],
            ],
            'invalidPattern: ファイルサイズ上限を超えている' => [
                'expected' => false,
                'input'    => [
                    'construct' => [
                        Define::make('5MiB', 'txt'),
                    ],
                    'execute' => [
                        './test-res/File/Validator/5MiB-gt.txt',
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
            'construct' => $construct,
            'execute'   => $execute,
        ] = $input;

        $validator = new Validator(...$construct);
        $actual    = $validator->execute(...$execute);
        $this->assertSame($expected, $actual->success());
    }
}
