<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Data;

use PHPUnit\Framework\TestCase;
use Selen\Data\ArrayType;

/**
 * @coversDefaultClass \Selen\Data\ArrayType
 *
 * @see ArrayType
 *
 * @internal
 */
class ArrayTypeTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataProviderValidate(): array
    {
        return [
            'pattern001' => ['expected' => true,  'input' => ['typeName' => 'int', 'data' => [1]]],
            'pattern002' => ['expected' => true,  'input' => ['typeName' => 'int', 'data' => [1, 2]]],
            'pattern003' => ['expected' => false, 'input' => ['typeName' => 'int', 'data' => [1, true]]],
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
            ArrayType::validate($input['data'], $input['typeName'])
        );
    }
}
