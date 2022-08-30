<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure\Test;

use PHPUnit\Framework\TestCase;
use Selen\Data\ArrayType;

/**
 * @coversDefaultClass \Selen\Data\ArrayType
 *
 * @group Selen/Data
 * @group Selen/Data/ArrayType
 *
 * @see \Selen\Data\ArrayType
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Data/ArrayType
 *
 * @internal
 */
class ArrayTypeTest extends TestCase
{
    public function dataProviderValidate()
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
    public function testValidate($expected, $input)
    {
        $this->assertSame(
            $expected,
            ArrayType::validate($input['data'], $input['typeName'])
        );
    }
}
