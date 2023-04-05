<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Validator\Attributes;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Validator\Attributes\Type;
use Selen\MongoDB\Validator\Model\ValidateResult;

/**
 * @requires PHP >= 8.0
 *
 * @coversDefaultClass \Selen\MongoDB\Validator\Attributes\Type
 *
 * @see \Selen\MongoDB\Validator\Attributes\Type
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
                    'type'  => ['int'],
                    'value' => 1,
                ], ],
            'pattern002' => [
                'expected' => new ValidateResult(false, '', 'Invalid type. Expected type int.'),
                'input'    => [
                    'type'  => ['int'],
                    'value' => 1.0,
                ], ],
            'pattern003' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'type'  => ['int', 'string'],
                    'value' => 'value',
                ], ],
            'pattern004' => [
                'expected' => new ValidateResult(false, '', 'Invalid type. Expected type int, string.'),
                'input'    => [
                    'type'  => ['int', 'string'],
                    'value' => true,
                ], ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param \Selen\MongoDB\Validator\Model\ValidateResult $expected
     * @param mixed $input
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
