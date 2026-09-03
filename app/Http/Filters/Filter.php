<?php

namespace App\Http\Filters;

abstract class Filter
{
    abstract public function query(array $params);
}