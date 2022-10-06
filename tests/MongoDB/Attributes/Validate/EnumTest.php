<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Attributes\Validate\Enum;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Attributes\Validate\Enum;
use Selen\MongoDB\Validate\Model\ValidateResult;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Attributes\Validate\Enum
 *
 * @group Selen/MongoDB/Attributes/Validate/Enum
 *
 * @see \Selen\MongoDB\Attributes\Validate\Enum
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Attributes/Validate/Enum
 *
 * @internal
 */
class EnumTest extends TestCase
{
    public function testConstruct()
    {
        $instance = new Enum();

        $this->assertInstanceOf(Enum::class, $instance);
    }

    public function dataProviderExecute()
    {
        return [
            'pattern001' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'type'  => ['main', 'sub'],
                    'value' => 'main',
                ], ],
            'pattern002' => [
                'expected' => new ValidateResult(false, '', "Invalid value. expected value 'main', 'sub'."),
                'input'    => [
                    'type'  => ['main', 'sub'],
                    'value' => 'mai',
                ], ],
            'pattern003' => [
                'expected' => new ValidateResult(true),
                'input'    => [
                    'type'  => ['main', 'sub', true, 0],
                    'value' => 'sub',
                ], ],
            'pattern004' => [
                'expected' => new ValidateResult(false, '', "Invalid value. expected value 'main', true, 0."),
                'input'    => [
                    'type'  => ['main', true, 0],
                    'value' => [],
                ], ],
            'pattern005' => [
                'expected' => new ValidateResult(false, '', "Invalid value. expected value 'main', true, null."),
                'input'    => [
                    'type'  => ['main', true, null],
                    'value' => [],
                ], ],
            'pattern006' => [
                'expected' => new ValidateResult(false, '', "Invalid value. expected value 'main', false, 0.1."),
                'input'    => [
                    'type'  => ['main', false, 0.1],
                    'value' => [],
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
        $instance = new Enum(...$input['type']);
        $verify   = $instance->execute($input['value'], new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $verify);
        $this->assertSame($expected->getResult(), $verify->getResult());
        $this->assertSame($expected->getMessage(), $verify->getMessage());
        $this->assertSame($expected->getArrayPath(), $verify->getArrayPath());
    }
}
