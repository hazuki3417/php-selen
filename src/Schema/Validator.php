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
    /** @var ArrayDefine */
    private $arrayDefine;

    /** @var Validate\Model\ValidateResult[] */
    private $validateResults = [];

    /** @var ArrayPath */
    private $arrayPath;

    /**
     * インスタンスを生成します
     *
     * @return Validator
     */
    private function __construct()
    {
        $this->arrayPath = new ArrayPath();
    }

    /**
     * インスタンスを生成します
     */
    public static function new(): Validator
    {
        return new self();
    }

    /**
     * key・valueの検証処理を設定します（個別設定）
     */
    public function arrayDefine(ArrayDefine $arrayDefine): Validator
    {
        $this->arrayDefine = $arrayDefine;
        return $this;
    }

    /**
     * 検証処理を実行します
     *
     * @param array<mixed,mixed> $input 変換する配列を渡します
     */
    public function execute(array $input): ValidatorResult
    {
        $this->defineRoutine($input, $this->arrayDefine);
        return new ValidatorResult(...$this->validateResults);
    }

    /**
     * 定義した配列形式に変換します（個別設定）
     *
     * @param array<mixed,mixed> $input       変換する配列を渡します
     * @param ArrayDefine        $arrayDefine 変換の定義を渡します
     */
    private function defineRoutine(
        array $input,
        ArrayDefine $arrayDefine
    ): void {
        $this->arrayPath->down();

        /** 検証対象の配列にのみ存在するフィールドを検出する処理 */
        if ($arrayDefine->assocArrayDefineExists) {
            $inputKeys     = array_keys($input);
            $undefinedKeys = array_diff($inputKeys, $arrayDefine->keys);

            foreach ($undefinedKeys as $undefinedKey) {
                $this->arrayPath->setCurrentPath($undefinedKey);
                $this->validateResults[] = new ValidateResult(
                    false,
                    $this->getArrayPathStr(),
                    'Undefined key.'
                );
            }
        }

        /** @var Define $define */
        foreach ($arrayDefine->defines as $define) {
            if ($define->isAssocArrayDefine()) {
                $this->arrayPath->setCurrentPath($define->key->getName());
            }

            if ($define->isIndexArrayDefine()) {
                $this->arrayPath->setCurrentPath('[]');
            }

            if ($define->isKeyValidate()) {
                // keyの検証処理
                $validateResult = $this->keyValidate($define, $input);

                if (!$validateResult->getResult()) {
                    // 失敗したときのみ結果を保持する
                    $this->validateResults[] = $validateResult;
                    continue;
                }
            }

            if ($this->isUndefinedArrayKey($define, $input)) {
                // keyの検証が不要で、input側にkeyがないときに実行される処理
                continue;
            }

            if ($define->isValueValidate()) {
                // valueの検証処理

                /**
                 * TODO: バリデーションの処理順を統一する。x軸を型定義、y軸を配列の要素名として説明（2次元配列をイメージ）
                 *       isAssocArrayDefine(): x軸を先に処理してから、y軸を処理する
                 *       isIndexArrayDefine(): y軸を処理してから、x軸を処理する
                 */
                // 値バリデーションのループ（値のバリデーションは複数指定可能）
                if ($define->isAssocArrayDefine()) {
                    foreach ($define->valueValidateExecutes as $execute) {
                        // 連想配列のときの値バリデーション処理
                        $validateResult = $this->valueValidate($execute, $input[$define->key->getName()]);

                        if (!$validateResult->getResult()) {
                            // 検証結果が不合格の場合は控えている検証処理は実行しない
                            // 失敗したときのみ結果を保持する
                            $this->validateResults[] = $validateResult;
                            break;
                        }
                        // 検証結果が合格の場合は控えている検証処理を実行する。
                        continue;
                    }
                }

                if ($define->isIndexArrayDefine()) {
                    foreach ($define->valueValidateExecutes as $execute) {
                        // 要素配列のときの値バリデーション処理
                        $keyValues = $input;
                        /** @var bool 配列要素すべてのバリデーションが合格ならtrue、それ以外ならfalse */
                        $oneLoopValidateResult = true;

                        foreach ($keyValues as $key => $value) {
                            $this->arrayPath->setCurrentPath(\sprintf('[%s]', $key));
                            $validateResult = $this->valueValidate($execute, $value);

                            if (!$validateResult->getResult()) {
                                $oneLoopValidateResult   = false;
                                $this->validateResults[] = $validateResult;
                            }
                        }

                        if (!$oneLoopValidateResult) {
                            // 配列要素のうち1つでもバリデーション違反した場合は、控えている検証処理は実行しない
                            break;
                        }
                        // 配列要素すべてのバリデーションを合格した場合は、控えている検証処理を実行する。
                        continue;
                    }
                }
            }

            if ($define->nestedTypeDefineExists()) {
                // ネストされた定義なら再帰処理を行う
                if ($define->isAssocArrayDefine()) {
                    $passRecursionInput = $input[$define->key->getName()];

                    // 値が配列以外の場合は値のバリデーションエラーとする。（ネストされた定義 = 配列形式のため）
                    if (!\is_array($passRecursionInput)) {
                        // keyは存在するが、値が配列型以外の場合はエラーとする
                        $this->validateResults[] = new ValidateResult(
                            false,
                            $this->getArrayPathStr(),
                            'Invalid value. Expecting a value of array type.'
                        );
                        continue;
                    }

                    // keyが存在する + 値が配列型なら再帰処理する
                    $this->defineRoutine(
                        $passRecursionInput,
                        $define->arrayDefine
                    );
                }

                if ($define->isIndexArrayDefine()) {
                    if ($input === []) {
                        // NOTE: index配列 + 空配列のときは値がないときなのでバリデーションしない
                        continue;
                    }

                    $items = $input;

                    foreach ($items as $index => $item) {
                        $path = \sprintf('[%s]', $index);
                        $this->arrayPath->setCurrentPath($path);

                        if (\is_string($index)) {
                            // 要素名に文字列が指定されている = 連想配列
                            $this->validateResults[] = new ValidateResult(
                                false,
                                $this->getArrayPathStr(),
                                'Invalid key. Expecting indexed array type.'
                            );
                            continue;
                        }

                        if (!\is_array($item)) {
                            $this->validateResults[] = new ValidateResult(
                                false,
                                $this->getArrayPathStr(),
                                'Invalid value. Expecting a value of array type.'
                            );
                            continue;
                        }
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
     * 定義されたkeyが入力側に存在しないかどうか確認します
     *
     * @param Define             $define 定義を指定します
     * @param array<mixed,mixed> $input  入力側の配列を指定します
     *
     * @return bool 存在しない場合はtrueを、それ以外の場合はfalseを返します
     */
    private function isUndefinedArrayKey(Define $define, array $input): bool
    {
        // NOTE: 定義側のkey名はnullを許容していない。nullのときはindex array定義なので検証は必要
        if ($define->key->getName() === null) {
            return false;
        }
        // 定義したkeyがinput側に存在しない場合、要素参照するとUndefinedが発生するため検証は不要
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
     * @param Define $define
     * @param mixed  $value
     */
    private function keyValidate($define, $value): ValidateResult
    {
        $validateResult = new ValidateResult(true, $this->getArrayPathStr());
        return \array_key_exists($define->key->getName(), $value) ?
            $validateResult :
            $validateResult
                ->setResult(false)
                ->setMessage('key is required.');
    }

    /**
     * 値の検証処理を行います
     *
     * @param ValueValidateInterface|callable $execute
     * @param mixed                           $value
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
