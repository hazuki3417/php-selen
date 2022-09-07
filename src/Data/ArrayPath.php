<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

class ArrayPath
{
    private $paths = [];
    private $currentIndex = 0;

    public function up(): bool
    {
        if ($this->currentIndex <= 0) {
            return false;
        }
        --$this->currentIndex;
        return true;
    }

    public function down(): bool
    {
        ++$this->currentIndex;

        if(!isset($this->paths[$this->currentIndex])){
            $this->paths[$this->currentIndex] = '';
        }

        return true;
    }

    public function set(string $pathName){
        $this->paths[$this->current()] = $pathName;
    }

    public function fetch(int $start, int $end){
        if($start < 0){
            throw new \ValueError('Invalid value range for $start.');
        }

        if(count($this->paths) < $end){
            throw new \ValueError('Invalid value range for $end.');
        }

        if($end < $start){
            throw new \ValueError('Invalid value range. Please specify a value smaller than $end for $start.');
        }

        $length = ($end - $start) + 1;

        return \array_slice($this->paths, $start, $length);
    }

    public function current(): int
    {
        return $this->currentIndex;
    }

    public static function toString(array $paths): string{
        $separator = '.';
        return \implode($separator, $paths);
    }
}
