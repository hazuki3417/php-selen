<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\MongoDB\Validate\Model\ValidateResult;

use PHPUnit\Framework\TestCase;
use Selen\MongoDB\Validate\Model\ValidateResult;

/**
 * @requires PHP >= 8.0
 * @coversDefaultClass \Selen\MongoDB\Validate\Model\ValidateResult
 *
 * @group Selen
 * @group Selen/MongoDB
 * @group Selen/MongoDB/Validate
 * @group Selen/MongoDB/Validate/Model
 * @group Selen/MongoDB/Validate/Model/ValidateResult
 *
 * @see \Selen\MongoDB\Validate\Model\ValidateResult
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/MongoDB/Validate/Model/ValidateResult
 *
 * @internal
 */
class ValidateResultTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(ValidateResult::class, new ValidateResult());
    }

    public function testSetResult()
    {
        $this->assertInstanceOf(ValidateResult::class, (new ValidateResult())->setResult(true));
    }

    public function testSetArrayPath()
    {
        $this->assertInstanceOf(ValidateResult::class, (new ValidateResult())->setArrayPath(''));
    }

    public function testSetMessage()
    {
        $this->assertInstanceOf(ValidateResult::class, (new ValidateResult())->setMessage(''));
    }

    public function testGetResult1()
    {
        $this->assertTrue((new ValidateResult())->getResult());
    }

    public function dataProviderGetResult()
    {
        return [
            'pattern001' => ['expected' => true,  'input' => true],
            'pattern002' => ['expected' => false, 'input' => false],
        ];
    }

    /**
     * @dataProvider dataProviderGetResult
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetResult2($expected, $input)
    {
        $this->assertSame($expected, (new ValidateResult($input))->getResult());
    }

    /**
     * @dataProvider dataProviderGetResult
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetResult3($expected, $input)
    {
        $instance = new ValidateResult();
        $this->assertSame($expected, $instance->setResult($input)->getResult());
    }

    public function testGetArrayPath1()
    {
        $this->assertSame('', (new ValidateResult())->getArrayPath());
    }

    public function dataProviderGetArrayPath()
    {
        return [
            'pattern001' => ['expected' => '',      'input' => ''],
            'pattern002' => ['expected' => 'aaaaa', 'input' => 'aaaaa'],
        ];
    }

    /**
     * @dataProvider dataProviderGetArrayPath
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetArrayPath2($expected, $input)
    {
        $this->assertSame($expected, (new ValidateResult(true, $input))->getArrayPath());
    }

    /**
     * @dataProvider dataProviderGetArrayPath
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetArrayPath3($expected, $input)
    {
        $instance = new ValidateResult();
        $this->assertSame($expected, $instance->setArrayPath($input)->getArrayPath());
    }

    public function testGetMessage1()
    {
        $this->assertSame('', (new ValidateResult())->getMessage());
    }

    public function dataProviderGetMessage()
    {
        return [
            'pattern001' => ['expected' => '',      'input' => ''],
            'pattern002' => ['expected' => 'aaaaa', 'input' => 'aaaaa'],
        ];
    }

    /**
     * @dataProvider dataProviderGetMessage
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetMessage2($expected, $input)
    {
        $this->assertSame($expected, (new ValidateResult(true, '', $input))->getMessage());
    }

    /**
     * @dataProvider dataProviderGetMessage
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetMessage3($expected, $input)
    {
        $instance = new ValidateResult();
        $this->assertSame($expected, $instance->setMessage($input)->getMessage());
    }
}
