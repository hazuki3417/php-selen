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
 * @group Selen/MongoDB/Validator/Attributes/Type
 *
 * @see \Selen\MongoDB\Validator\Attributes\Type
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Validator/Attributes/Type
 *
 * @internal
 */
class TypeTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Type();

        $this->assertInstanceOf(Type::class, $instance);
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
                'expected' => new ValidateResult(false, '', 'Invalid type. expected type int.'),
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
                'expected' => new ValidateResult(false, '', 'Invalid type. expected type int, string.'),
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
        $validateResult = new ValidateResult();

        $instance = new Type(...$input['type']);

        $verify = $instance->execute($input['value'], $validateResult);

        $this->assertInstanceOf(ValidateResult::class, $verify);
        $this->assertSame($expected->getResult(), $verify->getResult());
        $this->assertSame($expected->getMessage(), $verify->getMessage());
        $this->assertSame($expected->getArrayPath(), $verify->getArrayPath());
    }
}
