<?php

namespace App\Services\Cart\Contracts;

interface CartInterface
{
    public function get($key);
    public function put($key, $value);
    public function all();
    public function has($key);
    public function forget($key);
    public function clear();
    public function count();

}
