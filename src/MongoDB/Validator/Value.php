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
    /** @var \Selen\Data\ArrayPath */
    private $arrayPath;

    /** @var \ReflectionAttribute[] */
    private $attributeValueValidates = [];

    public function __construct(ArrayPath $arrayPath, array $attributeValueValidates)
    {
        $this->arrayPath               = $arrayPath;
        $this->attributeValueValidates = $attributeValueValidates;
    }

    public function execute(string $key, array $input): ValidatorResult
    {
        $this->arrayPath->setCurrentPath($key);
        $arrayPathStr   = ArrayPath::toString($this->arrayPath->getPaths());
        $validateResult = new ValidateResult();
        $validateResult->setArrayPath($arrayPathStr);

        /** @var \Selen\MongoDB\Validator\Model\ValidateResult[] */
        $validateResults = [];

        foreach ($this->attributeValueValidates as $attributeValueValidate) {
            /** @var \Selen\MongoDB\Validator\ValueValidateInterface */
            $valueValidateInstance = $attributeValueValidate->newInstance();
            $validateResults[]     = $valueValidateInstance->execute($input[$key], $validateResult);
        }
        return new ValidatorResult(...$validateResults);
    }
}