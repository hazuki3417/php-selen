<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema;

use Selen\Data\ArrayPath;
use Selen\Schema\Validate\ArrayDefine;
use Selen\Schema\Validate\Define;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Model\ValidatorResult;
use Selen\Schema\Validate\ValueValidateInterface;

class Validator
{
    /** @var bool */
    private $additionalKey = false;

    /** @var \Selen\Schema\Validate\ArrayDefine */
    private $arrayDefine;

    /** @var \Selen\Schema\Validate\Model\ValidateResult[] */
    private $validateResults = [];

    /** @var \Selen\Data\ArrayPath */
    private $arrayPath;

    /**
     * インスタンスを生成します
     *
     * @return \Selen\Schema\Validator
     */
    private function __construct()
    {
        $this->arrayPath = new ArrayPath();
    }

    /**
     * インスタンスを生成します
     *
     * @return \Selen\Schema\Validator
     */
    public static function new(): Validator
    {
        return new self();
    }

    /**
     * 追加キーの検証を行うかどうか指定します
     *
     * TODO: 本体処理は未実装。
     *
     * @param bool $verify 追加キーの検証を行う場合はtrueを、行わない場合はfalseを渡します
     *
     * @return \Selen\Schema\Validator
     */
    public function additionalKey(bool $verify = false): Validator
    {
        $this->additionalKey = $verify;
        return $this;
    }

    /**
     * key・valueの検証処理を設定します（個別設定）
     *
     * @return \Selen\Schema\Validator
     */
    public function arrayDefine(ArrayDefine $arrayDefine): Validator
    {
        $this->arrayDefine = $arrayDefine;
        return $this;
    }

    /**
     * 検証処理を実行します
     *
     * @param array $input 変換する配列を渡します
     */
    public function execute(array $input): ValidatorResult
    {
        $this->defineRoutine($input, $this->arrayDefine);
        return new ValidatorResult(...$this->validateResults);
    }

    /**
     * 定義した配列形式に変換します（個別設定）
     *
     * @param array $input 変換する配列を渡します
     * @param \Selen\Schema\Validate\ArrayDefine $arrayDefine 変換の定義を渡します
     *
     * @return array 変換した配列を返します
     */
    private function defineRoutine(
        array $input,
        ArrayDefine $arrayDefine
    ) {
        $this->arrayPath->down();
        /** @var \Selen\Schema\Validate\Define $define */
        foreach ($arrayDefine->defines as $define) {
            if ($define->isAssocArrayDefine()) {
                $this->arrayPath->setCurrentPath($define->key->getName());
            }

            if ($define->isIndexArrayDefine()) {
                $this->arrayPath->setCurrentPath('[]');
            }

            if ($define->isKeyValidate()) {
                // keyの検証処理
                $validateResult          = $this->keyValidate($define, $input);
                $this->validateResults[] = $validateResult;
            }

            if ($define->isValueValidate()) {
                // valueの検証処理
                if ($this->isSkipValueValidate($define, $input)) {
                    continue;
                }

                foreach ($define->valueValidateExecutes as $execute) {
                    $validateResult = $define->isAssocArrayDefine() ?
                        $this->valueValidate($execute, $input[$define->key->getName()]) :
                        $this->valueValidate($execute, $input);
                    $this->validateResults[] = $validateResult;

                    if ($validateResult->getResult()) {
                        // 検証結果が合格の場合は控えている検証処理を実行する
                        continue;
                    }
                    // 検証結果が不合格の場合は控えている検証処理は実行しない
                    break;
                }
                continue;
            }

            if ($define->nestedTypeDefineExists()) {
                // ネストされた定義なら再帰処理を行う
                $passRecursionInput = [];

                if ($define->isAssocArrayDefine()) {
                    if (\array_key_exists($define->key->getName(), $input)) {
                        $passRecursionInput = $input[$define->key->getName()];
                    }

                    /**
                     * keyに対応する値が配列以外の場合は、値の形式が不正。
                     * そのため空配列を渡して処理を継続させる。
                     * ネストされた定義 = inputの値は配列形式を期待している
                     */
                    $passRecursionInput = \is_array($passRecursionInput)
                        ? $passRecursionInput : [];
                    $this->defineRoutine(
                        $passRecursionInput,
                        $define->arrayDefine
                    );
                }

                if ($define->isIndexArrayDefine()) {
                    // NOTE: inputが空の場合は検証処理を実行するために2次元配列を返す
                    $passRecursionInput = $input === [] ? [[]] : $input;

                    foreach ($passRecursionInput as $index => $item) {
                        $path = \sprintf('[%s]', $index);
                        $this->arrayPath->setCurrentPath($path);
                        $this->defineRoutine(
                            $item,
                            $define->arrayDefine
                        );
                    }
                }
            }
        }
        $this->arrayPath->up();
    }

    /**
     * 値のバリデーション処理をスキップするかどうか確認します
     *
     * @param \Selen\Schema\Validator\Define $define
     *
     * @return bool スキップする場合はtrueを、それ以外の場合はfalseを返します
     */
    private function isSkipValueValidate(Define $define, array $input): bool
    {
        // NOTE: 定義側のkey名はnullを許容していない。nullのときはindex array定義なので検証は必要
        if ($define->key->getName() === null) {
            return false;
        }
        return !array_key_exists($define->key->getName(), $input);
    }

    /**
     * 配列の階層パス文字列を取得します
     *
     * @return string 配列の階層パス文字列を返します
     */
    private function getArrayPathStr(): string
    {
        return ArrayPath::toString($this->arrayPath->getPaths());
    }

    /**
     * keyの検証処理を行います
     *
     * @param \Selen\Schema\Validate\Define $define
     * @param mixed $value
     */
    private function keyValidate($define, $value): ValidateResult
    {
        $validateResult = new ValidateResult(true, $this->getArrayPathStr());
        return \array_key_exists($define->key->getName(), $value) ?
            $validateResult :
            $validateResult
                ->setResult(false)
                ->setMessage('key is required');
    }

    /**
     * 値の検証処理を行います
     *
     * @param \Selen\Schema\Validate\ValueValidateInterface|callable $execute
     * @param mixed $value
     */
    private function valueValidate($execute, $value): ValidateResult
    {
        $validateResult = new ValidateResult(true, $this->getArrayPathStr());

        if ($execute instanceof ValueValidateInterface) {
            return $execute->execute($value, $validateResult);
        }
        return \call_user_func($execute, $value, $validateResult);
    }
}
