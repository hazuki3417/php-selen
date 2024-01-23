<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Data\Structure;

use PHPUnit\Framework\TestCase;
use Selen\Data\ArrayTypes;

/**
 * @coversDefaultClass \Selen\Data\ArrayTypes
 *
 * @see ArrayTypes
 *
 * @internal
 */
class ArrayTypesTest extends TestCase
{
    public function dataProviderValidate()
    {
        return [
            'pattern001' => ['expected' => true,  'input' => ['typeName1' => 'int', 'typeName2' => 'string', 'data' => [0]]],
            'pattern002' => ['expected' => true,  'input' => ['typeName1' => 'int', 'typeName2' => 'string', 'data' => [0, '0']]],
            'pattern003' => ['expected' => false, 'input' => ['typeName1' => 'int', 'typeName2' => 'string', 'data' => [0, '0', true]]],
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
            ArrayTypes::validate($input['data'], $input['typeName1'], $input['typeName2'])
        );
    }
}
