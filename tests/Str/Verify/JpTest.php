<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Str\Verify;

use PHPUnit\Framework\TestCase;
use Selen\Str\Verify\Jp;

/**
 * @coversDefaultClass \Selen\Str\Verify\Jp
 *
 * @group Selen/Verify/Str
 * @group Selen/Verify/Str/Jp
 *
 * @see \Selen\Str\Verify\Jp
 *
 * [command]
 * php ./vendor/bin/phpunit --group=Selen/Verify/Str/Jp
 *
 * @internal
 */
class JpTest extends TestCase
{
    public function dataProviderHiragana()
    {
        return [
            // カタカナ（単一文字判定）
            'validPattern: 001' => ['expected' => true, 'input' => 'ぁ'],
            'validPattern: 002' => ['expected' => true, 'input' => 'あ'],
            'validPattern: 003' => ['expected' => true, 'input' => 'ぃ'],
            'validPattern: 004' => ['expected' => true, 'input' => 'い'],
            'validPattern: 005' => ['expected' => true, 'input' => 'ぅ'],
            'validPattern: 006' => ['expected' => true, 'input' => 'う'],
            'validPattern: 007' => ['expected' => true, 'input' => 'ぇ'],
            'validPattern: 008' => ['expected' => true, 'input' => 'え'],
            'validPattern: 009' => ['expected' => true, 'input' => 'ぉ'],
            'validPattern: 010' => ['expected' => true, 'input' => 'お'],
            'validPattern: 011' => ['expected' => true, 'input' => 'か'],
            'validPattern: 012' => ['expected' => true, 'input' => 'が'],
            'validPattern: 013' => ['expected' => true, 'input' => 'き'],
            'validPattern: 014' => ['expected' => true, 'input' => 'ぎ'],
            'validPattern: 015' => ['expected' => true, 'input' => 'く'],
            'validPattern: 016' => ['expected' => true, 'input' => 'ぐ'],
            'validPattern: 017' => ['expected' => true, 'input' => 'け'],
            'validPattern: 018' => ['expected' => true, 'input' => 'げ'],
            'validPattern: 019' => ['expected' => true, 'input' => 'こ'],
            'validPattern: 020' => ['expected' => true, 'input' => 'ご'],
            'validPattern: 021' => ['expected' => true, 'input' => 'さ'],
            'validPattern: 022' => ['expected' => true, 'input' => 'ざ'],
            'validPattern: 023' => ['expected' => true, 'input' => 'し'],
            'validPattern: 024' => ['expected' => true, 'input' => 'じ'],
            'validPattern: 025' => ['expected' => true, 'input' => 'す'],
            'validPattern: 026' => ['expected' => true, 'input' => 'ず'],
            'validPattern: 027' => ['expected' => true, 'input' => 'せ'],
            'validPattern: 028' => ['expected' => true, 'input' => 'ぜ'],
            'validPattern: 029' => ['expected' => true, 'input' => 'そ'],
            'validPattern: 030' => ['expected' => true, 'input' => 'ぞ'],
            'validPattern: 031' => ['expected' => true, 'input' => 'た'],
            'validPattern: 032' => ['expected' => true, 'input' => 'だ'],
            'validPattern: 033' => ['expected' => true, 'input' => 'ち'],
            'validPattern: 034' => ['expected' => true, 'input' => 'ぢ'],
            'validPattern: 035' => ['expected' => true, 'input' => 'っ'],
            'validPattern: 036' => ['expected' => true, 'input' => 'つ'],
            'validPattern: 037' => ['expected' => true, 'input' => 'づ'],
            'validPattern: 038' => ['expected' => true, 'input' => 'て'],
            'validPattern: 039' => ['expected' => true, 'input' => 'で'],
            'validPattern: 040' => ['expected' => true, 'input' => 'と'],
            'validPattern: 041' => ['expected' => true, 'input' => 'ど'],
            'validPattern: 042' => ['expected' => true, 'input' => 'な'],
            'validPattern: 043' => ['expected' => true, 'input' => 'に'],
            'validPattern: 044' => ['expected' => true, 'input' => 'ぬ'],
            'validPattern: 045' => ['expected' => true, 'input' => 'ね'],
            'validPattern: 046' => ['expected' => true, 'input' => 'の'],
            'validPattern: 047' => ['expected' => true, 'input' => 'は'],
            'validPattern: 048' => ['expected' => true, 'input' => 'ば'],
            'validPattern: 049' => ['expected' => true, 'input' => 'ぱ'],
            'validPattern: 050' => ['expected' => true, 'input' => 'ひ'],
            'validPattern: 051' => ['expected' => true, 'input' => 'び'],
            'validPattern: 052' => ['expected' => true, 'input' => 'ぴ'],
            'validPattern: 053' => ['expected' => true, 'input' => 'ふ'],
            'validPattern: 054' => ['expected' => true, 'input' => 'ぶ'],
            'validPattern: 055' => ['expected' => true, 'input' => 'ぷ'],
            'validPattern: 056' => ['expected' => true, 'input' => 'へ'],
            'validPattern: 057' => ['expected' => true, 'input' => 'べ'],
            'validPattern: 058' => ['expected' => true, 'input' => 'ぺ'],
            'validPattern: 059' => ['expected' => true, 'input' => 'ほ'],
            'validPattern: 060' => ['expected' => true, 'input' => 'ぼ'],
            'validPattern: 061' => ['expected' => true, 'input' => 'ぽ'],
            'validPattern: 062' => ['expected' => true, 'input' => 'ま'],
            'validPattern: 063' => ['expected' => true, 'input' => 'み'],
            'validPattern: 064' => ['expected' => true, 'input' => 'む'],
            'validPattern: 065' => ['expected' => true, 'input' => 'め'],
            'validPattern: 066' => ['expected' => true, 'input' => 'も'],
            'validPattern: 067' => ['expected' => true, 'input' => 'ゃ'],
            'validPattern: 068' => ['expected' => true, 'input' => 'や'],
            'validPattern: 069' => ['expected' => true, 'input' => 'ゅ'],
            'validPattern: 070' => ['expected' => true, 'input' => 'ゆ'],
            'validPattern: 071' => ['expected' => true, 'input' => 'ょ'],
            'validPattern: 072' => ['expected' => true, 'input' => 'よ'],
            'validPattern: 073' => ['expected' => true, 'input' => 'ら'],
            'validPattern: 074' => ['expected' => true, 'input' => 'り'],
            'validPattern: 075' => ['expected' => true, 'input' => 'る'],
            'validPattern: 076' => ['expected' => true, 'input' => 'れ'],
            'validPattern: 077' => ['expected' => true, 'input' => 'ろ'],
            'validPattern: 078' => ['expected' => true, 'input' => 'ゎ'],
            'validPattern: 079' => ['expected' => true, 'input' => 'わ'],
            'validPattern: 080' => ['expected' => true, 'input' => 'ゐ'],
            'validPattern: 081' => ['expected' => true, 'input' => 'ゑ'],
            'validPattern: 082' => ['expected' => true, 'input' => 'を'],
            'validPattern: 083' => ['expected' => true, 'input' => 'ん'],
            'validPattern: 084' => ['expected' => true, 'input' => 'ゔ'],
            'validPattern: 085' => ['expected' => true, 'input' => 'ゕ'],
            'validPattern: 086' => ['expected' => true, 'input' => 'ゖ'],
            // カタカナ（複数文字判定）
            'validPattern: 087' => ['expected' => true, 'input' => 'ぁゖ'],

            // 記号
            'invalidPattern: 001' => ['expected' => false, 'input' => '゙'],
            'invalidPattern: 002' => ['expected' => false, 'input' => '゚'],
            'invalidPattern: 003' => ['expected' => false, 'input' => '゛'],
            'invalidPattern: 004' => ['expected' => false, 'input' => '゜'],
            'invalidPattern: 005' => ['expected' => false, 'input' => 'ゝ'],
            'invalidPattern: 006' => ['expected' => false, 'input' => 'ゞ'],
            'invalidPattern: 007' => ['expected' => false, 'input' => 'ゟ'],
            'invalidPattern: 008' => ['expected' => false, 'input' => '・'],
            'invalidPattern: 009' => ['expected' => false, 'input' => 'ー'],
            'invalidPattern: 010' => ['expected' => false, 'input' => 'ヽ'],
            'invalidPattern: 011' => ['expected' => false, 'input' => 'ヾ'],
            'invalidPattern: 012' => ['expected' => false, 'input' => 'ヿ'],
            // カタカナ以外の文字
            'invalidPattern: 013' => ['expected' => false, 'input' => 'ア'],
            'invalidPattern: 014' => ['expected' => false, 'input' => 'a'],
            'invalidPattern: 015' => ['expected' => false, 'input' => 'A'],
            'invalidPattern: 016' => ['expected' => false, 'input' => 'ａ'],
            'invalidPattern: 017' => ['expected' => false, 'input' => 'Ａ'],
            'invalidPattern: 018' => ['expected' => false, 'input' => '1'],
            'invalidPattern: 019' => ['expected' => false, 'input' => '漢'],
            // 複数文字の判定
            'invalidPattern: 020' => ['expected' => false, 'input' => '漢字'],
        ];
    }

    /**
     * @dataProvider dataProviderHiragana
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testHiragana($expected, $input)
    {
        $this->assertSame($expected, Jp::isHiragana($input));
    }

    public function dataProviderKatakana()
    {
        return [
            // カタカナ（単一文字判定）
            'validPattern: 001' => ['expected' => true, 'input' => 'ァ'],
            'validPattern: 002' => ['expected' => true, 'input' => 'ア'],
            'validPattern: 003' => ['expected' => true, 'input' => 'ィ'],
            'validPattern: 004' => ['expected' => true, 'input' => 'イ'],
            'validPattern: 005' => ['expected' => true, 'input' => 'ゥ'],
            'validPattern: 006' => ['expected' => true, 'input' => 'ウ'],
            'validPattern: 007' => ['expected' => true, 'input' => 'ェ'],
            'validPattern: 008' => ['expected' => true, 'input' => 'エ'],
            'validPattern: 009' => ['expected' => true, 'input' => 'ォ'],
            'validPattern: 010' => ['expected' => true, 'input' => 'オ'],
            'validPattern: 011' => ['expected' => true, 'input' => 'カ'],
            'validPattern: 012' => ['expected' => true, 'input' => 'ガ'],
            'validPattern: 013' => ['expected' => true, 'input' => 'キ'],
            'validPattern: 014' => ['expected' => true, 'input' => 'ギ'],
            'validPattern: 015' => ['expected' => true, 'input' => 'ク'],
            'validPattern: 016' => ['expected' => true, 'input' => 'グ'],
            'validPattern: 017' => ['expected' => true, 'input' => 'ケ'],
            'validPattern: 018' => ['expected' => true, 'input' => 'ゲ'],
            'validPattern: 019' => ['expected' => true, 'input' => 'コ'],
            'validPattern: 020' => ['expected' => true, 'input' => 'ゴ'],
            'validPattern: 021' => ['expected' => true, 'input' => 'サ'],
            'validPattern: 022' => ['expected' => true, 'input' => 'ザ'],
            'validPattern: 023' => ['expected' => true, 'input' => 'シ'],
            'validPattern: 024' => ['expected' => true, 'input' => 'ジ'],
            'validPattern: 025' => ['expected' => true, 'input' => 'ス'],
            'validPattern: 026' => ['expected' => true, 'input' => 'ズ'],
            'validPattern: 027' => ['expected' => true, 'input' => 'セ'],
            'validPattern: 028' => ['expected' => true, 'input' => 'ゼ'],
            'validPattern: 029' => ['expected' => true, 'input' => 'ソ'],
            'validPattern: 030' => ['expected' => true, 'input' => 'ゾ'],
            'validPattern: 031' => ['expected' => true, 'input' => 'タ'],
            'validPattern: 032' => ['expected' => true, 'input' => 'ダ'],
            'validPattern: 033' => ['expected' => true, 'input' => 'チ'],
            'validPattern: 034' => ['expected' => true, 'input' => 'ヂ'],
            'validPattern: 035' => ['expected' => true, 'input' => 'ッ'],
            'validPattern: 036' => ['expected' => true, 'input' => 'ツ'],
            'validPattern: 037' => ['expected' => true, 'input' => 'ヅ'],
            'validPattern: 038' => ['expected' => true, 'input' => 'テ'],
            'validPattern: 039' => ['expected' => true, 'input' => 'デ'],
            'validPattern: 040' => ['expected' => true, 'input' => 'ト'],
            'validPattern: 041' => ['expected' => true, 'input' => 'ド'],
            'validPattern: 042' => ['expected' => true, 'input' => 'ナ'],
            'validPattern: 043' => ['expected' => true, 'input' => 'ニ'],
            'validPattern: 044' => ['expected' => true, 'input' => 'ヌ'],
            'validPattern: 045' => ['expected' => true, 'input' => 'ネ'],
            'validPattern: 046' => ['expected' => true, 'input' => 'ノ'],
            'validPattern: 047' => ['expected' => true, 'input' => 'ハ'],
            'validPattern: 048' => ['expected' => true, 'input' => 'バ'],
            'validPattern: 049' => ['expected' => true, 'input' => 'パ'],
            'validPattern: 050' => ['expected' => true, 'input' => 'ヒ'],
            'validPattern: 051' => ['expected' => true, 'input' => 'ビ'],
            'validPattern: 052' => ['expected' => true, 'input' => 'ピ'],
            'validPattern: 053' => ['expected' => true, 'input' => 'フ'],
            'validPattern: 054' => ['expected' => true, 'input' => 'ブ'],
            'validPattern: 055' => ['expected' => true, 'input' => 'プ'],
            'validPattern: 056' => ['expected' => true, 'input' => 'ヘ'],
            'validPattern: 057' => ['expected' => true, 'input' => 'ベ'],
            'validPattern: 058' => ['expected' => true, 'input' => 'ペ'],
            'validPattern: 059' => ['expected' => true, 'input' => 'ホ'],
            'validPattern: 060' => ['expected' => true, 'input' => 'ボ'],
            'validPattern: 061' => ['expected' => true, 'input' => 'ポ'],
            'validPattern: 062' => ['expected' => true, 'input' => 'マ'],
            'validPattern: 063' => ['expected' => true, 'input' => 'ミ'],
            'validPattern: 064' => ['expected' => true, 'input' => 'ム'],
            'validPattern: 065' => ['expected' => true, 'input' => 'メ'],
            'validPattern: 066' => ['expected' => true, 'input' => 'モ'],
            'validPattern: 067' => ['expected' => true, 'input' => 'ャ'],
            'validPattern: 068' => ['expected' => true, 'input' => 'ヤ'],
            'validPattern: 069' => ['expected' => true, 'input' => 'ュ'],
            'validPattern: 070' => ['expected' => true, 'input' => 'ユ'],
            'validPattern: 071' => ['expected' => true, 'input' => 'ョ'],
            'validPattern: 072' => ['expected' => true, 'input' => 'ヨ'],
            'validPattern: 073' => ['expected' => true, 'input' => 'ラ'],
            'validPattern: 074' => ['expected' => true, 'input' => 'リ'],
            'validPattern: 075' => ['expected' => true, 'input' => 'ル'],
            'validPattern: 076' => ['expected' => true, 'input' => 'レ'],
            'validPattern: 077' => ['expected' => true, 'input' => 'ロ'],
            'validPattern: 078' => ['expected' => true, 'input' => 'ヮ'],
            'validPattern: 079' => ['expected' => true, 'input' => 'ワ'],
            'validPattern: 080' => ['expected' => true, 'input' => 'ヰ'],
            'validPattern: 081' => ['expected' => true, 'input' => 'ヱ'],
            'validPattern: 082' => ['expected' => true, 'input' => 'ヲ'],
            'validPattern: 083' => ['expected' => true, 'input' => 'ン'],
            'validPattern: 084' => ['expected' => true, 'input' => 'ヴ'],
            'validPattern: 085' => ['expected' => true, 'input' => 'ヵ'],
            'validPattern: 086' => ['expected' => true, 'input' => 'ヶ'],
            'validPattern: 087' => ['expected' => true, 'input' => 'ヷ'],
            'validPattern: 088' => ['expected' => true, 'input' => 'ヸ'],
            'validPattern: 089' => ['expected' => true, 'input' => 'ヹ'],
            'validPattern: 090' => ['expected' => true, 'input' => 'ヺ'],
            // カタカナ（複数文字判定）
            'validPattern: 091' => ['expected' => true, 'input' => 'ァヺ'],

            // 記号
            'invalidPattern: 001' => ['expected' => false, 'input' => '゙'],
            'invalidPattern: 002' => ['expected' => false, 'input' => '゚'],
            'invalidPattern: 003' => ['expected' => false, 'input' => '゛'],
            'invalidPattern: 004' => ['expected' => false, 'input' => '゜'],
            'invalidPattern: 005' => ['expected' => false, 'input' => 'ゝ'],
            'invalidPattern: 006' => ['expected' => false, 'input' => 'ゞ'],
            'invalidPattern: 007' => ['expected' => false, 'input' => 'ゟ'],
            'invalidPattern: 008' => ['expected' => false, 'input' => '・'],
            'invalidPattern: 009' => ['expected' => false, 'input' => 'ー'],
            'invalidPattern: 010' => ['expected' => false, 'input' => 'ヽ'],
            'invalidPattern: 011' => ['expected' => false, 'input' => 'ヾ'],
            'invalidPattern: 012' => ['expected' => false, 'input' => 'ヿ'],
            // カタカナ以外の文字
            'invalidPattern: 013' => ['expected' => false, 'input' => 'あ'],
            'invalidPattern: 014' => ['expected' => false, 'input' => 'a'],
            'invalidPattern: 015' => ['expected' => false, 'input' => 'A'],
            'invalidPattern: 016' => ['expected' => false, 'input' => 'ａ'],
            'invalidPattern: 017' => ['expected' => false, 'input' => 'Ａ'],
            'invalidPattern: 018' => ['expected' => false, 'input' => '1'],
            'invalidPattern: 019' => ['expected' => false, 'input' => '漢'],
            // 複数文字の判定
            'invalidPattern: 020' => ['expected' => false, 'input' => '漢字'],
        ];
    }

    /**
     * @dataProvider dataProviderKatakana
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testKatakana($expected, $input)
    {
        $this->assertSame($expected, Jp::isKatakana($input));
    }
}
