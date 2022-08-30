<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Verify\Str\Test;

use PHPUnit\Framework\TestCase;
use Selen\Verify\Str\Jp;

/**
 * @coversDefaultClass \Selen\Verify\Str\Jp
 *
 * @group Selen/Verify/Str
 * @group Selen/Verify/Str/Jp
 *
 * @see \Selen\Verify\Str\Jp
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Verify/Str/Jp
 *
 * @internal
 */
class Radix2Test extends TestCase
{
    public function dataProviderHira()
    {
        return [
            // カタカナ（単一文字判定）
            'pattern001' => ['expected' => true, 'input' => 'ぁ'],
            'pattern002' => ['expected' => true, 'input' => 'あ'],
            'pattern003' => ['expected' => true, 'input' => 'ぃ'],
            'pattern004' => ['expected' => true, 'input' => 'い'],
            'pattern005' => ['expected' => true, 'input' => 'ぅ'],
            'pattern006' => ['expected' => true, 'input' => 'う'],
            'pattern007' => ['expected' => true, 'input' => 'ぇ'],
            'pattern008' => ['expected' => true, 'input' => 'え'],
            'pattern009' => ['expected' => true, 'input' => 'ぉ'],
            'pattern010' => ['expected' => true, 'input' => 'お'],
            'pattern011' => ['expected' => true, 'input' => 'か'],
            'pattern012' => ['expected' => true, 'input' => 'が'],
            'pattern013' => ['expected' => true, 'input' => 'き'],
            'pattern014' => ['expected' => true, 'input' => 'ぎ'],
            'pattern015' => ['expected' => true, 'input' => 'く'],
            'pattern016' => ['expected' => true, 'input' => 'ぐ'],
            'pattern017' => ['expected' => true, 'input' => 'け'],
            'pattern018' => ['expected' => true, 'input' => 'げ'],
            'pattern019' => ['expected' => true, 'input' => 'こ'],
            'pattern020' => ['expected' => true, 'input' => 'ご'],
            'pattern021' => ['expected' => true, 'input' => 'さ'],
            'pattern022' => ['expected' => true, 'input' => 'ざ'],
            'pattern023' => ['expected' => true, 'input' => 'し'],
            'pattern024' => ['expected' => true, 'input' => 'じ'],
            'pattern025' => ['expected' => true, 'input' => 'す'],
            'pattern026' => ['expected' => true, 'input' => 'ず'],
            'pattern027' => ['expected' => true, 'input' => 'せ'],
            'pattern028' => ['expected' => true, 'input' => 'ぜ'],
            'pattern029' => ['expected' => true, 'input' => 'そ'],
            'pattern030' => ['expected' => true, 'input' => 'ぞ'],
            'pattern031' => ['expected' => true, 'input' => 'た'],
            'pattern032' => ['expected' => true, 'input' => 'だ'],
            'pattern033' => ['expected' => true, 'input' => 'ち'],
            'pattern034' => ['expected' => true, 'input' => 'ぢ'],
            'pattern035' => ['expected' => true, 'input' => 'っ'],
            'pattern036' => ['expected' => true, 'input' => 'つ'],
            'pattern037' => ['expected' => true, 'input' => 'づ'],
            'pattern038' => ['expected' => true, 'input' => 'て'],
            'pattern039' => ['expected' => true, 'input' => 'で'],
            'pattern040' => ['expected' => true, 'input' => 'と'],
            'pattern041' => ['expected' => true, 'input' => 'ど'],
            'pattern042' => ['expected' => true, 'input' => 'な'],
            'pattern043' => ['expected' => true, 'input' => 'に'],
            'pattern044' => ['expected' => true, 'input' => 'ぬ'],
            'pattern045' => ['expected' => true, 'input' => 'ね'],
            'pattern046' => ['expected' => true, 'input' => 'の'],
            'pattern047' => ['expected' => true, 'input' => 'は'],
            'pattern048' => ['expected' => true, 'input' => 'ば'],
            'pattern049' => ['expected' => true, 'input' => 'ぱ'],
            'pattern050' => ['expected' => true, 'input' => 'ひ'],
            'pattern051' => ['expected' => true, 'input' => 'び'],
            'pattern052' => ['expected' => true, 'input' => 'ぴ'],
            'pattern053' => ['expected' => true, 'input' => 'ふ'],
            'pattern054' => ['expected' => true, 'input' => 'ぶ'],
            'pattern055' => ['expected' => true, 'input' => 'ぷ'],
            'pattern056' => ['expected' => true, 'input' => 'へ'],
            'pattern057' => ['expected' => true, 'input' => 'べ'],
            'pattern058' => ['expected' => true, 'input' => 'ぺ'],
            'pattern059' => ['expected' => true, 'input' => 'ほ'],
            'pattern060' => ['expected' => true, 'input' => 'ぼ'],
            'pattern061' => ['expected' => true, 'input' => 'ぽ'],
            'pattern062' => ['expected' => true, 'input' => 'ま'],
            'pattern063' => ['expected' => true, 'input' => 'み'],
            'pattern064' => ['expected' => true, 'input' => 'む'],
            'pattern065' => ['expected' => true, 'input' => 'め'],
            'pattern066' => ['expected' => true, 'input' => 'も'],
            'pattern067' => ['expected' => true, 'input' => 'ゃ'],
            'pattern068' => ['expected' => true, 'input' => 'や'],
            'pattern069' => ['expected' => true, 'input' => 'ゅ'],
            'pattern070' => ['expected' => true, 'input' => 'ゆ'],
            'pattern071' => ['expected' => true, 'input' => 'ょ'],
            'pattern072' => ['expected' => true, 'input' => 'よ'],
            'pattern073' => ['expected' => true, 'input' => 'ら'],
            'pattern074' => ['expected' => true, 'input' => 'り'],
            'pattern075' => ['expected' => true, 'input' => 'る'],
            'pattern076' => ['expected' => true, 'input' => 'れ'],
            'pattern077' => ['expected' => true, 'input' => 'ろ'],
            'pattern078' => ['expected' => true, 'input' => 'ゎ'],
            'pattern079' => ['expected' => true, 'input' => 'わ'],
            'pattern080' => ['expected' => true, 'input' => 'ゐ'],
            'pattern081' => ['expected' => true, 'input' => 'ゑ'],
            'pattern082' => ['expected' => true, 'input' => 'を'],
            'pattern083' => ['expected' => true, 'input' => 'ん'],
            'pattern084' => ['expected' => true, 'input' => 'ゔ'],
            'pattern085' => ['expected' => true, 'input' => 'ゕ'],
            'pattern086' => ['expected' => true, 'input' => 'ゖ'],

            // カタカナ（記号）
            'pattern088' => ['expected' => false, 'input' => '゙'],
            'pattern090' => ['expected' => false, 'input' => '゚'],
            'pattern091' => ['expected' => false, 'input' => '゛'],
            'pattern092' => ['expected' => false, 'input' => '゜'],
            'pattern093' => ['expected' => false, 'input' => 'ゝ'],
            'pattern094' => ['expected' => false, 'input' => 'ゞ'],
            'pattern095' => ['expected' => false, 'input' => 'ゟ'],
            // カタカナ（複数文字判定）
            'pattern096' => ['expected' => true, 'input' => 'ぁゖ'],
            // カタカナ以外の文字
            'pattern097' => ['expected' => false, 'input' => 'ア'],
            'pattern098' => ['expected' => false, 'input' => 'a'],
            'pattern099' => ['expected' => false, 'input' => 'A'],
            'pattern100' => ['expected' => false, 'input' => 'ａ'],
            'pattern101' => ['expected' => false, 'input' => 'Ａ'],
            'pattern102' => ['expected' => false, 'input' => '1'],
            'pattern103' => ['expected' => false, 'input' => '漢'],
            // 複数文字の判定
            'pattern104' => ['expected' => false, 'input' => '漢字'],
        ];
    }

    /**
     * @dataProvider dataProviderHira
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testHira($expected, $input)
    {
        $this->assertSame($expected, Jp::isHira($input));
    }

    public function dataProviderKana()
    {
        return [
            // カタカナ（単一文字判定）
            'pattern001' => ['expected' => true, 'input' => 'ァ'],
            'pattern002' => ['expected' => true, 'input' => 'ア'],
            'pattern003' => ['expected' => true, 'input' => 'ィ'],
            'pattern004' => ['expected' => true, 'input' => 'イ'],
            'pattern005' => ['expected' => true, 'input' => 'ゥ'],
            'pattern006' => ['expected' => true, 'input' => 'ウ'],
            'pattern007' => ['expected' => true, 'input' => 'ェ'],
            'pattern008' => ['expected' => true, 'input' => 'エ'],
            'pattern009' => ['expected' => true, 'input' => 'ォ'],
            'pattern010' => ['expected' => true, 'input' => 'オ'],
            'pattern011' => ['expected' => true, 'input' => 'カ'],
            'pattern012' => ['expected' => true, 'input' => 'ガ'],
            'pattern013' => ['expected' => true, 'input' => 'キ'],
            'pattern014' => ['expected' => true, 'input' => 'ギ'],
            'pattern015' => ['expected' => true, 'input' => 'ク'],
            'pattern016' => ['expected' => true, 'input' => 'グ'],
            'pattern017' => ['expected' => true, 'input' => 'ケ'],
            'pattern018' => ['expected' => true, 'input' => 'ゲ'],
            'pattern019' => ['expected' => true, 'input' => 'コ'],
            'pattern020' => ['expected' => true, 'input' => 'ゴ'],
            'pattern021' => ['expected' => true, 'input' => 'サ'],
            'pattern022' => ['expected' => true, 'input' => 'ザ'],
            'pattern023' => ['expected' => true, 'input' => 'シ'],
            'pattern024' => ['expected' => true, 'input' => 'ジ'],
            'pattern025' => ['expected' => true, 'input' => 'ス'],
            'pattern026' => ['expected' => true, 'input' => 'ズ'],
            'pattern027' => ['expected' => true, 'input' => 'セ'],
            'pattern028' => ['expected' => true, 'input' => 'ゼ'],
            'pattern029' => ['expected' => true, 'input' => 'ソ'],
            'pattern030' => ['expected' => true, 'input' => 'ゾ'],
            'pattern031' => ['expected' => true, 'input' => 'タ'],
            'pattern032' => ['expected' => true, 'input' => 'ダ'],
            'pattern033' => ['expected' => true, 'input' => 'チ'],
            'pattern034' => ['expected' => true, 'input' => 'ヂ'],
            'pattern035' => ['expected' => true, 'input' => 'ッ'],
            'pattern036' => ['expected' => true, 'input' => 'ツ'],
            'pattern037' => ['expected' => true, 'input' => 'ヅ'],
            'pattern038' => ['expected' => true, 'input' => 'テ'],
            'pattern039' => ['expected' => true, 'input' => 'デ'],
            'pattern040' => ['expected' => true, 'input' => 'ト'],
            'pattern041' => ['expected' => true, 'input' => 'ド'],
            'pattern042' => ['expected' => true, 'input' => 'ナ'],
            'pattern043' => ['expected' => true, 'input' => 'ニ'],
            'pattern044' => ['expected' => true, 'input' => 'ヌ'],
            'pattern045' => ['expected' => true, 'input' => 'ネ'],
            'pattern046' => ['expected' => true, 'input' => 'ノ'],
            'pattern047' => ['expected' => true, 'input' => 'ハ'],
            'pattern048' => ['expected' => true, 'input' => 'バ'],
            'pattern049' => ['expected' => true, 'input' => 'パ'],
            'pattern050' => ['expected' => true, 'input' => 'ヒ'],
            'pattern051' => ['expected' => true, 'input' => 'ビ'],
            'pattern052' => ['expected' => true, 'input' => 'ピ'],
            'pattern053' => ['expected' => true, 'input' => 'フ'],
            'pattern054' => ['expected' => true, 'input' => 'ブ'],
            'pattern055' => ['expected' => true, 'input' => 'プ'],
            'pattern056' => ['expected' => true, 'input' => 'ヘ'],
            'pattern057' => ['expected' => true, 'input' => 'ベ'],
            'pattern058' => ['expected' => true, 'input' => 'ペ'],
            'pattern059' => ['expected' => true, 'input' => 'ホ'],
            'pattern060' => ['expected' => true, 'input' => 'ボ'],
            'pattern061' => ['expected' => true, 'input' => 'ポ'],
            'pattern062' => ['expected' => true, 'input' => 'マ'],
            'pattern063' => ['expected' => true, 'input' => 'ミ'],
            'pattern064' => ['expected' => true, 'input' => 'ム'],
            'pattern065' => ['expected' => true, 'input' => 'メ'],
            'pattern066' => ['expected' => true, 'input' => 'モ'],
            'pattern067' => ['expected' => true, 'input' => 'ャ'],
            'pattern068' => ['expected' => true, 'input' => 'ヤ'],
            'pattern069' => ['expected' => true, 'input' => 'ュ'],
            'pattern070' => ['expected' => true, 'input' => 'ユ'],
            'pattern071' => ['expected' => true, 'input' => 'ョ'],
            'pattern072' => ['expected' => true, 'input' => 'ヨ'],
            'pattern073' => ['expected' => true, 'input' => 'ラ'],
            'pattern074' => ['expected' => true, 'input' => 'リ'],
            'pattern075' => ['expected' => true, 'input' => 'ル'],
            'pattern076' => ['expected' => true, 'input' => 'レ'],
            'pattern077' => ['expected' => true, 'input' => 'ロ'],
            'pattern078' => ['expected' => true, 'input' => 'ヮ'],
            'pattern079' => ['expected' => true, 'input' => 'ワ'],
            'pattern080' => ['expected' => true, 'input' => 'ヰ'],
            'pattern081' => ['expected' => true, 'input' => 'ヱ'],
            'pattern082' => ['expected' => true, 'input' => 'ヲ'],
            'pattern083' => ['expected' => true, 'input' => 'ン'],
            'pattern084' => ['expected' => true, 'input' => 'ヴ'],
            'pattern085' => ['expected' => true, 'input' => 'ヵ'],
            'pattern086' => ['expected' => true, 'input' => 'ヶ'],
            'pattern087' => ['expected' => true, 'input' => 'ヷ'],
            'pattern088' => ['expected' => true, 'input' => 'ヸ'],
            'pattern089' => ['expected' => true, 'input' => 'ヹ'],
            'pattern090' => ['expected' => true, 'input' => 'ヺ'],
            // カタカナ（記号）
            'pattern091' => ['expected' => false, 'input' => '・'],
            'pattern092' => ['expected' => false, 'input' => 'ー'],
            'pattern093' => ['expected' => false, 'input' => 'ヽ'],
            'pattern094' => ['expected' => false, 'input' => 'ヾ'],
            'pattern095' => ['expected' => false, 'input' => 'ヿ'],

            // カタカナ（複数文字判定）
            'pattern096' => ['expected' => true, 'input' => 'ァヺ'],

            // カタカナ以外の文字
            'pattern097' => ['expected' => false, 'input' => 'あ'],
            'pattern098' => ['expected' => false, 'input' => 'a'],
            'pattern099' => ['expected' => false, 'input' => 'A'],
            'pattern100' => ['expected' => false, 'input' => 'ａ'],
            'pattern101' => ['expected' => false, 'input' => 'Ａ'],
            'pattern102' => ['expected' => false, 'input' => '1'],
            'pattern103' => ['expected' => false, 'input' => '漢'],
            // 複数文字の判定
            'pattern104' => ['expected' => false, 'input' => '漢字'],
        ];
    }

    /**
     * @dataProvider dataProviderKana
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testKana($expected, $input)
    {
        $this->assertSame($expected, Jp::isKana($input));
    }
}
