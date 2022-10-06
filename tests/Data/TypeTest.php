<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Data\Structure;

use PHPUnit\Framework\TestCase;
use Selen\Data\Type;

/**
 * @coversDefaultClass \Selen\Data\Type
 *
 * @group Selen/Data
 * @group Selen/Data/Type
 *
 * @see \Selen\Data\Type
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Data/Type
 *
 * @internal
 */
class TypeTest extends TestCase
{
    public function dataProviderValidate()
    {
        return [
            'pattern001' => ['expected' => true,  'input' => ['typeName' => 'array', 'data' => []]],
            'pattern002' => ['expected' => false, 'input' => ['typeName' => 'array', 'data' => true]],
            'pattern003' => ['expected' => false, 'input' => ['typeName' => 'array', 'data' => 1.0]],
            'pattern004' => ['expected' => false, 'input' => ['typeName' => 'array', 'data' => -1.0]],
            'pattern005' => ['expected' => false, 'input' => ['typeName' => 'array', 'data' => 1]],
            'pattern006' => ['expected' => false, 'input' => ['typeName' => 'array', 'data' => null]],
            'pattern007' => ['expected' => false, 'input' => ['typeName' => 'array', 'data' => '1']],
            'pattern008' => ['expected' => false, 'input' => ['typeName' => 'array', 'data' => 'data']],
            'pattern009' => ['expected' => false, 'input' => ['typeName' => 'array', 'data' => new \DateTime()]],

            'pattern011' => ['expected' => false, 'input' => ['typeName' => 'bool', 'data' => []]],
            'pattern012' => ['expected' => true,  'input' => ['typeName' => 'bool', 'data' => true]],
            'pattern013' => ['expected' => false, 'input' => ['typeName' => 'bool', 'data' => 1.0]],
            'pattern014' => ['expected' => false, 'input' => ['typeName' => 'bool', 'data' => -1.0]],
            'pattern015' => ['expected' => false, 'input' => ['typeName' => 'bool', 'data' => 1]],
            'pattern016' => ['expected' => false, 'input' => ['typeName' => 'bool', 'data' => null]],
            'pattern017' => ['expected' => false, 'input' => ['typeName' => 'bool', 'data' => '1']],
            'pattern018' => ['expected' => false, 'input' => ['typeName' => 'bool', 'data' => 'data']],
            'pattern019' => ['expected' => false, 'input' => ['typeName' => 'bool', 'data' => new \DateTime()]],

            'pattern021' => ['expected' => false, 'input' => ['typeName' => 'double', 'data' => []]],
            'pattern022' => ['expected' => false, 'input' => ['typeName' => 'double', 'data' => true]],
            'pattern023' => ['expected' => true,  'input' => ['typeName' => 'double', 'data' => 1.0]],
            'pattern024' => ['expected' => true,  'input' => ['typeName' => 'double', 'data' => -1.0]],
            'pattern025' => ['expected' => false, 'input' => ['typeName' => 'double', 'data' => 1]],
            'pattern026' => ['expected' => false, 'input' => ['typeName' => 'double', 'data' => null]],
            'pattern027' => ['expected' => false, 'input' => ['typeName' => 'double', 'data' => '1']],
            'pattern028' => ['expected' => false, 'input' => ['typeName' => 'double', 'data' => 'data']],
            'pattern029' => ['expected' => false, 'input' => ['typeName' => 'double', 'data' => new \DateTime()]],

            'pattern031' => ['expected' => false, 'input' => ['typeName' => 'float', 'data' => []]],
            'pattern032' => ['expected' => false, 'input' => ['typeName' => 'float', 'data' => true]],
            'pattern033' => ['expected' => true,  'input' => ['typeName' => 'float', 'data' => 1.0]],
            'pattern034' => ['expected' => true,  'input' => ['typeName' => 'float', 'data' => -1.0]],
            'pattern035' => ['expected' => false, 'input' => ['typeName' => 'float', 'data' => 1]],
            'pattern036' => ['expected' => false, 'input' => ['typeName' => 'float', 'data' => null]],
            'pattern037' => ['expected' => false, 'input' => ['typeName' => 'float', 'data' => '1']],
            'pattern038' => ['expected' => false, 'input' => ['typeName' => 'float', 'data' => 'data']],
            'pattern039' => ['expected' => false, 'input' => ['typeName' => 'float', 'data' => new \DateTime()]],

            'pattern041' => ['expected' => false, 'input' => ['typeName' => 'int', 'data' => []]],
            'pattern042' => ['expected' => false, 'input' => ['typeName' => 'int', 'data' => true]],
            'pattern043' => ['expected' => false, 'input' => ['typeName' => 'int', 'data' => 1.0]],
            'pattern044' => ['expected' => false, 'input' => ['typeName' => 'int', 'data' => -1.0]],
            'pattern045' => ['expected' => true,  'input' => ['typeName' => 'int', 'data' => 1]],
            'pattern046' => ['expected' => false, 'input' => ['typeName' => 'int', 'data' => null]],
            'pattern047' => ['expected' => false, 'input' => ['typeName' => 'int', 'data' => '1']],
            'pattern048' => ['expected' => false, 'input' => ['typeName' => 'int', 'data' => 'data']],
            'pattern049' => ['expected' => false, 'input' => ['typeName' => 'int', 'data' => new \DateTime()]],

            'pattern051' => ['expected' => false, 'input' => ['typeName' => 'integer', 'data' => []]],
            'pattern052' => ['expected' => false, 'input' => ['typeName' => 'integer', 'data' => true]],
            'pattern053' => ['expected' => false, 'input' => ['typeName' => 'integer', 'data' => 1.0]],
            'pattern054' => ['expected' => false, 'input' => ['typeName' => 'integer', 'data' => -1.0]],
            'pattern055' => ['expected' => true,  'input' => ['typeName' => 'integer', 'data' => 1]],
            'pattern056' => ['expected' => false, 'input' => ['typeName' => 'integer', 'data' => null]],
            'pattern057' => ['expected' => false, 'input' => ['typeName' => 'integer', 'data' => '1']],
            'pattern058' => ['expected' => false, 'input' => ['typeName' => 'integer', 'data' => 'data']],
            'pattern059' => ['expected' => false, 'input' => ['typeName' => 'integer', 'data' => new \DateTime()]],

            'pattern061' => ['expected' => false, 'input' => ['typeName' => 'long', 'data' => []]],
            'pattern062' => ['expected' => false, 'input' => ['typeName' => 'long', 'data' => true]],
            'pattern063' => ['expected' => false, 'input' => ['typeName' => 'long', 'data' => 1.0]],
            'pattern064' => ['expected' => false, 'input' => ['typeName' => 'long', 'data' => -1.0]],
            'pattern065' => ['expected' => true,  'input' => ['typeName' => 'long', 'data' => 1]],
            'pattern066' => ['expected' => false, 'input' => ['typeName' => 'long', 'data' => null]],
            'pattern067' => ['expected' => false, 'input' => ['typeName' => 'long', 'data' => '1']],
            'pattern068' => ['expected' => false, 'input' => ['typeName' => 'long', 'data' => 'data']],
            'pattern069' => ['expected' => false, 'input' => ['typeName' => 'long', 'data' => new \DateTime()]],

            'pattern071' => ['expected' => false, 'input' => ['typeName' => 'null', 'data' => []]],
            'pattern072' => ['expected' => false, 'input' => ['typeName' => 'null', 'data' => true]],
            'pattern073' => ['expected' => false, 'input' => ['typeName' => 'null', 'data' => 1.0]],
            'pattern074' => ['expected' => false, 'input' => ['typeName' => 'null', 'data' => -1.0]],
            'pattern075' => ['expected' => false, 'input' => ['typeName' => 'null', 'data' => 1]],
            'pattern076' => ['expected' => true,  'input' => ['typeName' => 'null', 'data' => null]],
            'pattern077' => ['expected' => false, 'input' => ['typeName' => 'null', 'data' => '1']],
            'pattern078' => ['expected' => false, 'input' => ['typeName' => 'null', 'data' => 'data']],
            'pattern079' => ['expected' => false, 'input' => ['typeName' => 'null', 'data' => new \DateTime()]],

            'pattern081' => ['expected' => false, 'input' => ['typeName' => 'numeric', 'data' => []]],
            'pattern082' => ['expected' => false, 'input' => ['typeName' => 'numeric', 'data' => true]],
            'pattern083' => ['expected' => true,  'input' => ['typeName' => 'numeric', 'data' => 1.0]],
            'pattern084' => ['expected' => true,  'input' => ['typeName' => 'numeric', 'data' => -1.0]],
            'pattern085' => ['expected' => true,  'input' => ['typeName' => 'numeric', 'data' => 1]],
            'pattern086' => ['expected' => false, 'input' => ['typeName' => 'numeric', 'data' => null]],
            'pattern087' => ['expected' => true,  'input' => ['typeName' => 'numeric', 'data' => '1']],
            'pattern088' => ['expected' => false, 'input' => ['typeName' => 'numeric', 'data' => 'data']],
            'pattern089' => ['expected' => false, 'input' => ['typeName' => 'numeric', 'data' => new \DateTime()]],

            'pattern091' => ['expected' => false, 'input' => ['typeName' => 'scalar', 'data' => []]],
            'pattern092' => ['expected' => true,  'input' => ['typeName' => 'scalar', 'data' => true]],
            'pattern093' => ['expected' => true,  'input' => ['typeName' => 'scalar', 'data' => 1.0]],
            'pattern094' => ['expected' => true,  'input' => ['typeName' => 'scalar', 'data' => -1.0]],
            'pattern095' => ['expected' => true,  'input' => ['typeName' => 'scalar', 'data' => 1]],
            'pattern096' => ['expected' => false, 'input' => ['typeName' => 'scalar', 'data' => null]],
            'pattern097' => ['expected' => true,  'input' => ['typeName' => 'scalar', 'data' => '1']],
            'pattern098' => ['expected' => true,  'input' => ['typeName' => 'scalar', 'data' => 'data']],
            'pattern099' => ['expected' => false, 'input' => ['typeName' => 'scalar', 'data' => new \DateTime()]],

            'pattern101' => ['expected' => false, 'input' => ['typeName' => 'string', 'data' => []]],
            'pattern102' => ['expected' => false, 'input' => ['typeName' => 'string', 'data' => true]],
            'pattern103' => ['expected' => false, 'input' => ['typeName' => 'string', 'data' => 1.0]],
            'pattern104' => ['expected' => false, 'input' => ['typeName' => 'string', 'data' => -1.0]],
            'pattern105' => ['expected' => false, 'input' => ['typeName' => 'string', 'data' => 1]],
            'pattern106' => ['expected' => false, 'input' => ['typeName' => 'string', 'data' => null]],
            'pattern107' => ['expected' => true,  'input' => ['typeName' => 'string', 'data' => '1']],
            'pattern108' => ['expected' => true,  'input' => ['typeName' => 'string', 'data' => 'data']],
            'pattern109' => ['expected' => false, 'input' => ['typeName' => 'string', 'data' => new \DateTime()]],

            'pattern111' => ['expected' => false, 'input' => ['typeName' => \DateTime::class, 'data' => []]],
            'pattern112' => ['expected' => false, 'input' => ['typeName' => \DateTime::class, 'data' => true]],
            'pattern113' => ['expected' => false, 'input' => ['typeName' => \DateTime::class, 'data' => 1.0]],
            'pattern114' => ['expected' => false, 'input' => ['typeName' => \DateTime::class, 'data' => -1.0]],
            'pattern115' => ['expected' => false, 'input' => ['typeName' => \DateTime::class, 'data' => 1]],
            'pattern116' => ['expected' => false, 'input' => ['typeName' => \DateTime::class, 'data' => null]],
            'pattern117' => ['expected' => false, 'input' => ['typeName' => \DateTime::class, 'data' => '1']],
            'pattern118' => ['expected' => false, 'input' => ['typeName' => \DateTime::class, 'data' => 'data']],
            'pattern119' => ['expected' => true,  'input' => ['typeName' => \DateTime::class, 'data' => new \DateTime()]],
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
            Type::validate($input['data'], $input['typeName'])
        );
    }
}
