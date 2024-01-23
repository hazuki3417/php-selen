<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Schema\Validate\Values;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\Type;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\Type
 *
 * @see Type
 *
 * @internal
 */
class TypeTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(Type::class, new Type('string'));
    }

    public function dataProviderExecute()
    {
        return [
            'pattern001' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'type'  => ['string'],
                    'value' => 'true',
                ],
            ],
            'pattern002' => [
                'expected' => new ValidateResult(false, '', 'Invalid type. expected type string.'),
                'input'    => [
                    'type'  => ['string'],
                    'value' => true,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param ValidateResult $expected
     * @param mixed          $input
     */
    public function testExecute($expected, $input)
    {
        $actual = (new Type(...$input['type']))->execute($input['value'], new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $actual);
        $this->assertSame($expected->getResult(), $actual->getResult());
        $this->assertSame($expected->getArrayPath(), $actual->getArrayPath());
        $this->assertSame($expected->getMessage(), $actual->getMessage());
    }
}
