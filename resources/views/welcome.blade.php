<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('U-Shop (Unique Shop)') }}
        </h2>
    </x-slot>
    <br>

    <div class="container mx-auto px-4 grid grid-cols-4 gap-4">

        @foreach ($products as $product)
        <div>


            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <p class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">{{ $product->name }}</p>
                <img class="p-8 rounded-t-lg" src="https://www.refurbished.nl/cache/images/iphone-xsmax-spacegray-multiapple_600x600_BGresize_16777215-tj.webp" alt="product image" />
                <div class="px-5 pb-5">
                    <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->description }}</h5>
                    <div class="flex items-center mt-2.5 mb-5">

                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($product->price) }}</span>
                        <a href="{{ route('cart.add', ['product' => $product->id]) }}" class="text-white bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add to cart</a>
                    </div>
                </div>
            </div>

        </div>
        @endforeach

        
    </div>
    <br>


        {{ $products->links() }}
    
    <br>
    
</x-app-layout>