<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Attributes\Validate\Type\Test;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Validate\Type;
use Selen\MongoDB\Validate\Model\ValidateResult;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Validate\Type
 *
 * @group Selen/MongoDB/Attributes/Validate/Type
 *
 * @see \Selen\MongoDB\Attributes\Validate\Type
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Validate/Type
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
     * @param \Selen\MongoDB\Validate\Model\ValidateResult $expected
     * @param mixed $input
     */
    public function testExecute($expected, $input)
    {
        $instance = new Type(...$input['type']);
        $verify   = $instance->execute($input['value'], new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $verify);
        $this->assertSame($expected->getResult(), $verify->getResult());
        $this->assertSame($expected->getMessage(), $verify->getMessage());
        $this->assertSame($expected->getArrayPath(), $verify->getArrayPath());
    }
}
