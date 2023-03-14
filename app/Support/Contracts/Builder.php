<?php

namespace App\Support\Contracts;

interface Builder
{
    public function initialize(): void;

    public function calculate(): float;
}
