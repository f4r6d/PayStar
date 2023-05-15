@inject('cart', 'App\Services\Cart\Cart')

<!-- Sub total -->
<div class="mt-6 h-full rounded-lg border bg-white dark:text-gray-200  dark:bg-gray-700 p-6 shadow-md md:mt-0 md:w-1/3">
    <div class="mb-2 flex justify-between">
        <p class="text-gray-700 dark:text-gray-200 ">Subtotal</p>
        <p class="text-gray-700 dark:text-gray-200 ">{{ number_format($cart->subTotal()) }} Rials</p>
    </div>
    <div class="flex justify-between">
        <p class="text-gray-700 dark:text-gray-200 ">Shipping</p>
        <p class="text-gray-700 dark:text-gray-200 ">free</p>
    </div>
    <hr class="my-4" />
    <div class="flex justify-between">
        <p class="text-lg font-bold">Total</p>
        <div class="">
            <p class="mb-1 text-lg font-bold">{{ number_format($cart->subTotal()) }} Rials</p>
        </div>
    </div>
    @if (request()->is('cart'))
    <a href="{{ route('cart.checkout-form') }}">
        <button class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600">Check out</button>
    </a>
    <a href="{{ route('cart.clear') }}">
        <button class="mt-6 w-full rounded-md bg-red-500 py-1.5 font-medium text-red-50 hover:bg-red-600">Clear Cart</button>
    </a>
    @else
    <form action="{{ route('cart.checkout') }}" method="post">
        @csrf
        <input type="submit" value="Pay" class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600">
    </form>
    @endif
</div>