<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1 class="mb-10 text-center text-2xl font-bold">Cart Items</h1>
                    <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
                        <div class="rounded-lg md:w-2/3">

                            @forelse ($items as $item)

                            <div class="justify-between mb-6 rounded-lg bg-white  dark:bg-gray-700 p-6 shadow-md sm:flex sm:justify-start">
                                <img src="https://www.refurbished.nl/cache/images/iphone-xsmax-spacegray-multiapple_600x600_BGresize_16777215-tj.webp" alt="product-image" class="w-full rounded-lg dark:bg-slate-800 sm:w-40" />
                                <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                                    <div class="mt-5 sm:mt-0">
                                        <h2 class="text-lg font-bold dark:text-gray-2 dark:text-gray-200 text-gray-900">{{ $item->name }}</h2>
                                        <p class="mt-1 text-xs dark:text-gray-2 dark:text-gray-400 text-gray-700">{{ $item->description }}</p>
                                        <br><br>
                                        <p class="text-sm">{{ number_format($item->price) }} Rials</p>

                                    </div>
                                    <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">

                                        <div class="flex w-full px-6 items-center content-center border-gray-100">
                                            <div>
                                                <a href="{{ route('cart.remove', ['product' => $item->id]) }}" onclick="return confirm('Delete {{ $item->name }} from your cart?')">
                                                    <div class="flex w-full">
                                                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </div>
                                                </a>

                                                <form action="{{ route('cart.update', ['product' => $item->id]) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <input type="number" name="quantity" min="0" max="{{ $item->stock }}" value="{{ $item->quantity }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <input type="submit" value="Update" class="bg-slate-100  hover:bg-slate-200 text-slate-500 ring-offset-4 border-spacing-4 font-bold py-2 px-4 rounded-full">
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="justify-between mb-6 rounded-lg bg-white  dark:bg-gray-700 p-6 shadow-md sm:flex sm:justify-start">
                                <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                                    <div class="mt-5 sm:mt-0">
                                        <h2 class="text-lg font-bold dark:text-gray-200 text-gray-900">Empty</h2>
                                    </div>
                                </div>
                            </div>

                            @endforelse
                        </div>


                        @include('cart.subtotal')

                    </div>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>