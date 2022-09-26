<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB;

use ReflectionAttribute;
use ReflectionClass;
use Selen\Data\ArrayPath;
use Selen\MongoDB\Validate\FieldAttribute;
use Selen\MongoDB\Validate\Model\ValidateResult;
use Selen\MongoDB\Validate\Model\ValidatorResult;
use Selen\MongoDB\Validate\ObjectAttribute;

class Validator
{
    /** @var \Selen\Data\ArrayPath */
    private $arrayPath;

    /** @var \Selen\MongoDB\Validate\FieldAttribute[] */
    private $fieldAttributes = [];

    /** @var \Selen\MongoDB\Validate\Model\ValidateResult[] */
    private $validateResults = [];

    /**
     * インスタンスを生成します
     *
     * @return \Selen\MongoDB\Validator
     */
    private function __construct()
    {
        $this->arrayPath = new ArrayPath();
    }

    /**
     * インスタンスを生成します
     *
     * @return \Selen\MongoDB\Validator
     */
    public static function new(): Validator
    {
        return new self();
    }

    public function schema(string $name): Validator
    {
        $reflectionClass = new ReflectionClass($name);

        ObjectAttribute::extractObjectAttribute($reflectionClass);

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            if (FieldAttribute::isFieldAttributeExists($reflectionProperty)) {
                // Attributes/Schema/Fieldのattributeがある場合は処理対象とする
                $this->fieldAttributes[] = new FieldAttribute($reflectionProperty);
            }
            // Attributes/Schema/Fieldのattributeがない場合は処理対象外とする
        }

        return $this;
    }

    public function execute(array $input): ValidatorResult
    {
        $this->defineRoutine($input, $this->fieldAttributes);
        return new ValidatorResult(...$this->validateResults);
    }

    /**
     * メイン処理
     *
     * @param \Selen\MongoDB\Validate\FieldAttribute[]
     */
    private function defineRoutine(array $input, array $fieldAttributes)
    {
        $this->arrayPath->down();
        /** @var \Selen\MongoDB\Validate\FieldAttribute[] $fieldAttributes */
        foreach ($fieldAttributes as $fieldAttribute) {
            $this->arrayPath->setCurrentPath($fieldAttribute->getFieldName());

            $validateResult          = $this->keyValidate($fieldAttribute, $input);
            $this->validateResults[] = $validateResult;

            if (!$validateResult->getResult()) {
                // filedの検証結果が不合格なら値の検証は行わない
                continue;
            }

            if ($fieldAttribute->isValidateAttributeExists()) {
                // valueの検証処理
                foreach ($fieldAttribute->validateAttributes as $validateAttribute) {
                    $validateResult = $this->valueValidate(
                        $validateAttribute,
                        $input[$fieldAttribute->getFieldName()]
                    );
                    $this->validateResults[] = $validateResult;

                    if (!$validateResult->getResult()) {
                        // 検証結果が不合格の場合は控えている検証処理は実行しない
                        break;
                    }
                    // 検証結果が合格の場合は控えている検証処理を実行する
                }
                continue;
            }

            if ($fieldAttribute->isInnerObjectExists()) {
                // ネストされた定義なら再帰処理を行う
                $passRecursionInput = [];

                if ($fieldAttribute->isValidObjectDefine()) {
                    // valueがobjectのときの処理
                    $attributeName = \current($fieldAttribute->validAttribute->getArguments());

                    $reflectionClass = new ReflectionClass($attributeName);
                    ObjectAttribute::extractInnerObjectAttribute($reflectionClass);
                    $fieldAttributes = $this->createFieldAttributes($reflectionClass);

                    /**
                     * keyに対応する値が配列以外の場合は、値の形式が不正。
                     * そのため空配列を渡して処理を継続させる。
                     * ネストされた定義 = inputの値は配列形式を期待している
                     */
                    $passRecursionInput = $input[$fieldAttribute->getFieldName()];
                    $passRecursionInput = \is_array($passRecursionInput)
                        ? $passRecursionInput : [];
                    $this->defineRoutine($passRecursionInput, $fieldAttributes);
                }

                if ($fieldAttribute->isArrayObjectDefine()) {
                    // valueがarray objectのときの処理
                    $attributeName = \current($fieldAttribute->arrayValidAttribute->getArguments());

                    $reflectionClass = new ReflectionClass($attributeName);
                    ObjectAttribute::extractInnerObjectAttribute($reflectionClass);
                    $fieldAttributes = $this->createFieldAttributes($reflectionClass);

                    $passRecursionInput = $input[$fieldAttribute->getFieldName()];
                    $passRecursionInput = \is_array($passRecursionInput)
                        ? $passRecursionInput : [];
                    $passRecursionInput = $passRecursionInput === [] ? [[]] : $passRecursionInput;

                    $this->arrayPath->down();

                    foreach ($passRecursionInput as $index => $item) {
                        $path = \sprintf('[%s]', $index);
                        $this->arrayPath->setCurrentPath($path);
                        $this->defineRoutine(
                            $item,
                            $fieldAttributes
                        );
                    }
                    $this->arrayPath->up();
                }
            }
        }
        $this->arrayPath->up();
    }

    /**
     * @return \Selen\MongoDB\Validate\FieldAttribute[]
     */
    private function createFieldAttributes(ReflectionClass $reflectionClass)
    {
        /** @var \Selen\MongoDB\Validate\FieldAttribute $fieldAttributes */
        $fieldAttributes = [];

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            if (FieldAttribute::isFieldAttributeExists($reflectionProperty)) {
                // Attributes/Schema/Fieldのattributeがある場合は処理対象とする
                $fieldAttributes[] = new FieldAttribute($reflectionProperty);
            }
            // Attributes/Schema/Fieldのattributeがない場合は処理対象外とする
        }
        return $fieldAttributes;
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

    private function keyValidate(FieldAttribute $fieldAttribute, $value): ValidateResult
    {
        $validateResult = new ValidateResult(true, $this->getArrayPathStr());
        return \array_key_exists($fieldAttribute->getFieldName(), $value) ?
            $validateResult :
            $validateResult->setResult(false)->setMessage('field is required.');
    }

    private function valueValidate(ReflectionAttribute $validateAttribute, $value): ValidateResult
    {
        $validateResult = new ValidateResult(true, $this->getArrayPathStr());
        /** @var \Selen\MongoDB\Attributes\Validate\ValueValidateInterface $validateInstance */
        $validateInstance = $validateAttribute->newInstance();
        return $validateInstance->execute($value, $validateResult);
    }
}
