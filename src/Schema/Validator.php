<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema;

use Selen\Data\ArrayPath;
use Selen\Schema\Validate\ArrayDefine;
use Selen\Schema\Validate\Model\ValidateResult;
use Selen\Schema\Validate\Model\ValidatorResult;

class Validator
{
    /** @var \Selen\Schema\Validate\ArrayDefine||null */
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
     * key・valueの検証処理を設定します（個別設定）
     *
     * @return \Selen\Schema\Validator
     *
     * @param ?\Selen\Schema\Validate\ArrayDefine $arrayDefine
     */
    public function arrayDefine(?ArrayDefine $arrayDefine): Validator
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

    public function debug()
    {
        \var_dump('log', $this->validateResults);
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
        ?ArrayDefine $arrayDefine
    ) {
        if ($arrayDefine === null) {
            // 定義がないときの処理
            return;
        }

        // 定義があるときの処理

        $this->arrayPath->down();
        /** @var \Selen\Schema\Validate\Define $define */
        foreach ($arrayDefine->defines as $define) {
            if ($define->isAssocArrayDefine()) {
                $this->arrayPath->set($define->key->getName());
            }
            // NOTE: keyなしの場合は再帰処理の前段で配列パスの設定を行う

            /** @var bool $isSkipValueValidate 値の検証をスキップするかどうかを保持する変数 */
            $isSkipValueValidate = false;

            if ($define->isKeyValidate()) {
                // keyの検証処理
                $validateResult = $this->keyValidate($define, $input);
                $this->validateResults[] = $validateResult;
                // NOTE: keyが存在しない場合は値の検証をスキップする
                $isSkipValueValidate = !$validateResult->getResult();
            }

            if ($define->isValueValidate()) {
                // valueの検証処理
                if ($isSkipValueValidate) {
                    // NOTE: 値の検証は必要だが、keyが存在しないため検証できない。その場合はスキップする。
                    continue;
                }

                // NOTE: 値の検証が必要でkeyが存在するときは処理を継続する。
                if ($define->isAssocArrayDefine()) {
                    // key定義ありのときの処理
                    foreach ($define->valueValidateExecutes as $execute) {
                        $validateResult = $this->valueValidate($execute, $input[$define->key->getName()]);
                        $this->validateResults[] = $validateResult;
                    }
                    continue;
                }

                if ($define->isIndexArrayDefine()) {
                    // key定義なしのときの処理
                    foreach ($define->valueValidateExecutes as $execute) {
                        $validateResult = $this->valueValidate($execute, $input);
                        $this->validateResults[] = $validateResult;
                    }
                    continue;
                }
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
                        $this->arrayPath->set($path);
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

    private function getArrayPathStr(): string
    {
        $arrayPaths = $this->arrayPath->fetch(0, $this->arrayPath->current());
        return ArrayPath::toString($arrayPaths);
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

        if ($define->isAssocArrayDefine()) {
            return \array_key_exists($define->key->getName(), $value) ?
                $validateResult :
                $validateResult
                    ->setResult(false)
                    ->setMessage('key is required');
        }

        if ($define->isIndexArrayDefine()) {
            return $validateResult;
        }
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