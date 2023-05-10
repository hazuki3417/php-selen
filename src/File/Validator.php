<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Selen\File;

use Selen\Bool\Util as BoolUtil;
use Selen\File\Validate\Define;
use Selen\File\Validate\Model\ValidateResult;
use Selen\File\Validate\Model\ValidatorResult;

class Validator
{
    /** @var \Selen\File\Validate\Define[] */
    private array $defines;

    public function __construct(Define ...$defines)
    {
        $this->defines = $defines;
    }

    public function execute(string ...$filePaths): ValidatorResult
    {
        /** @var \Selen\File\Validate\Model\ValidateResult[] */
        $validResults = [];

        foreach ($filePaths as $filePath) {
            $validResult = new ValidateResult(false, $filePath);

            if (!\file_exists($filePath)) {
                $validResults[] = $validResult->setMessage('File does not exist.');
                continue;
            }

            if (!\is_file($filePath)) {
                $validResults[] = $validResult->setMessage('Specified path is not a file.');
                continue;
            }
            $errMessages = [];
            /**
             * バリデーション結果をスタックする変数
             * サイズ・拡張子制限のバリデーションを合格しているDefine::makeが1つ以上存在する場合は
             * バリデーション合格となる。
             */
            $specValidResults = [];

            foreach ($this->defines as $define) {
                $specValidResults[] = BoolUtil::allTrue(
                    $define->isAllowExtension($filePath),
                    $define->isUnderSizeLimit($filePath),
                );
                $errMessages[] = \sprintf(
                    '%s(%s)',
                    $define->getLimitSize(),
                    \implode('|', $define->getAllowExtensions())
                );
            }

            if (BoolUtil::allFalse(...$specValidResults)) {
                // バリデーションがすべて不合格だったとき
                $mes = \sprintf(
                    'Invalid file. Maximum file size and supported extensions %s.',
                    \implode(', ', $errMessages)
                );
                $validResults[] = $validResult->setMessage($mes);
                continue;
            }
            // バリデーションが1つでも合格だったときは何もしない
        }
        return new ValidatorResult(...$validResults);
    }
}
