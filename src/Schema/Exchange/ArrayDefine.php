<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Exchange;

class ArrayDefine
{
    /** @var \Selen\Schema\Exchange\Define[] */
    public $defines;

    /**
     * ArrayDefineインスタンスを作成します
     *
     * @param Define ...$defines 定義を渡します
     */
    public function __construct(Define ...$defines)
    {
        $indexArrayDefineExists = false;
        $assocArrayDefineExists = false;

        foreach ($defines as $define) {
            /** @var bool $isIndexDefineDuplicate index配列の定義が複数存在するか */
            $isIndexDefineDuplicate =
                $indexArrayDefineExists && $define->isIndexArrayDefine();

            if ($isIndexDefineDuplicate) {
                throw new \RuntimeException('keyなしの配列定義が複数存在しています');
            }

            if ($define->isIndexArrayDefine()) {
                $indexArrayDefineExists = true;
            }

            if ($define->isAssocArrayDefine()) {
                $assocArrayDefineExists = true;
            }

            $isDefineConflict =
                $indexArrayDefineExists && $assocArrayDefineExists;

            if ($isDefineConflict) {
                throw new \RuntimeException('keyあり・なしの配列定義が混在しています');
            }
        }

        $this->defines = $defines;
    }
}
