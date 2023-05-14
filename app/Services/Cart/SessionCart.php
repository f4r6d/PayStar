<?php

namespace App\Services\Cart;

use App\Services\Cart\Contracts\CartInterface;
use Countable;

class SessionCart implements CartInterface, Countable
{
    public function __construct(private $cart = "cart")
    {
    }

    public function get($key)
    {
        return session()->get($this->cart . '.' . $key);
    }

    public function put($key, $value)
    {
        return session()->put($this->cart . '.' . $key, $value);
    }

    public function all()
    {
        return session()->get($this->cart) ?? [];
    }

    public function has($key)
    {
        return session()->has($this->cart . '.' . $key);
    }

    public function forget($key)
    {
        return session()->forget($this->cart . '.' . $key);
    }

    public function clear()
    {
        return session()->forget($this->cart);
    }

    public function count(): int
    {
        return count($this->all());
    }
}
