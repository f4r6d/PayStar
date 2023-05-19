<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('U-Shop (Unique Shop)') }} <br>
            <p class="text-sm">Shop For The One Whom You Care..</p>
        </h2>
    </x-slot>
    <br>

    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">


            @foreach ($products as $product)
            <div class="flex justify-center">



                <a href="{{ route('products.show', $product) }}">
                    <div class=" w-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <br>
                        <p class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">{{ $product->name }}</p>
                        <img class="p-8 rounded-t-lg" src="{{ url('storage/'. ($product->image ?? 'default_image')) }}" alt="product image" />
                        <div class="px-5 pb-5">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->description }}</h5>

                            <br>
                            <div class="flex items-center mt-2.5 mb-5">
                                <p class=" font-mono text-gray-800 dark:text-gray-200 leading-tight text-center">Stock</p>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">{{ $product->stock }}</span>
                            </div>
                            <div class="flex items-center  justify-between">
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($product->price) }}</span>
                                <a href="{{ route('cart.add', ['product' => $product->id]) }}" class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-slate-400 dark:hover:bg-slate-500 dark:focus:ring-slate-800">Add to cart</a>
                            </div>
                        </div>
                    </div>

                </a>
            </div>

            @endforeach

        </div>
    </div>
    <br>


    {{ $products->links() }}

    <br>

</x-app-layout>