<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator;

use Selen\Data\ArrayPath;
use Selen\MongoDB\Validator\Model\ValidateResult;
use Selen\MongoDB\Validator\Model\ValidatorResult;

class Value
{
    /** @var ArrayPath */
    private $arrayPath;

    /** @var \ReflectionAttribute<object>[] */
    private $attributeValueValidates = [];

    /**
     * インスタンスを生成します
     *
     * @param \ReflectionAttribute<object>[] $attributeValueValidates
     */
    public function __construct(ArrayPath $arrayPath, array $attributeValueValidates)
    {
        $this->arrayPath               = $arrayPath;
        $this->attributeValueValidates = $attributeValueValidates;
    }

    /**
     * 値の検証を実行します
     *
     * @param string             $key   検証する値を保持しているキー名を渡します
     * @param array<mixed,mixed> $input 検証する値を渡します
     */
    public function execute(string $key, array $input): ValidatorResult
    {
        $this->arrayPath->setCurrentPath($key);
        $arrayPathStr   = ArrayPath::toString($this->arrayPath->getPaths());
        $validateResult = new ValidateResult();
        $validateResult->setArrayPath($arrayPathStr);

        foreach ($this->attributeValueValidates as $attributeValueValidate) {
            $valueValidateInstance = $attributeValueValidate->newInstance();
            $validateResult        = $valueValidateInstance->execute($input[$key], $validateResult);

            if (!$validateResult->getResult()) {
                return new ValidatorResult($validateResult);
            }
        }
        return new ValidatorResult();
    }
}
