<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Data;

use PHPUnit\Framework\TestCase;
use Selen\Data\Types;

/**
 * @coversDefaultClass \Selen\Data\Types
 *
 * @see Types
 *
 * @internal
 */
class TypesTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderValidate(): array
    {
        return [
            'pattern001' => ['expected' => true,  'input' => ['typeName1' => 'int',    'typeName2' => 'string', 'data' => 0]],
            'pattern002' => ['expected' => true,  'input' => ['typeName1' => 'int',    'typeName2' => 'string', 'data' => '0']],
            'pattern003' => ['expected' => false, 'input' => ['typeName1' => 'string', 'typeName2' => 'array',  'data' => true]],
        ];
    }

    /**
     * @dataProvider dataProviderValidate
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testValidate($expected, $input): void
    {
        $this->assertSame(
            $expected,
            Types::validate($input['data'], $input['typeName1'], $input['typeName2'])
        );
    }

    public function testValidateException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Types::validate('inputValue', 'string', 'string');
    }
}
