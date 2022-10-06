<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Values\Test;

use PHPUnit\Framework\TestCase;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Values\Type;

/**
 * @coversDefaultClass \Selen\Schema\Validate\Values\Type
 *
 * @group Selen
 * @group Selen/Schema
 * @group Selen/Schema/Validate
 * @group Selen/Schema/Validate/Values
 * @group Selen/Schema/Validate/Values/Type
 *
 * @see \Selen\Schema\Validate\Values\Type
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Schema/Validate/Values/Type
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
                ], ],
            'pattern002' => [
                'expected' => new ValidateResult(false, '', 'Invalid type. expected type string.'),
                'input'    => [
                    'type'  => ['string'],
                    'value' => true,
                ], ],
        ];
    }

    /**
     * @dataProvider dataProviderExecute
     *
     * @param \Selen\Schema\Validate\Model\ValidateResult $expected
     * @param mixed $input
     */
    public function testExecute($expected, $input)
    {
        $instance = new Type(...$input['type']);
        $verify   = $instance->execute($input['value'], new ValidateResult());

        $this->assertInstanceOf(ValidateResult::class, $verify);
        $this->assertSame($expected->getResult(), $verify->getResult());
        $this->assertSame($expected->getArrayPath(), $verify->getArrayPath());
        $this->assertSame($expected->getMessage(), $verify->getMessage());
    }
}
