<x-app-layout>
    <x-slot name="header">


        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
            {{ __('All Products') }}
        </x-nav-link>
        <x-nav-link :href="route('products.create')" :active="request()->routeIs('products.create')">
            {{ __('Add Product') }}
        </x-nav-link>
        @if (request()->routeIs('products.edit'))
        <x-nav-link :href="route('products.edit', $product)" :active="request()->routeIs('products.edit', $product)">
            Edit {{  $product->name }}
        </x-nav-link>
        @endif
        @if (request()->routeIs('products.show'))
        <x-nav-link :href="route('products.show', $product)" :active="request()->routeIs('products.show', $product)">
             {{  $product->name }} Detail
        </x-nav-link>
        @endif


    </x-slot>


    <div class="container mx-auto">
        <br>
        <div class=" p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">


        @if (request()->routeIs('products.create'))
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @else
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @method('patch')
                @endif
                @csrf

                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Name</label>
                    <input @if (request()->routeIs('products.edit')) value="{{ old('name', $product->name) }}" @endif type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Product Name" required>
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <br>

                <div class="mb-6">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Product description...">@if (request()->routeIs('products.edit')) {{ old('description', $product->description) }}" @endif</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
                <br>

                <div class="mb-6">
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                    <input @if (request()->routeIs('products.edit')) value="{{ old('price', $product->price) }}" @endif type="number" id="price" name="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Product $Price" required>
                    <x-input-error class="mt-2" :messages="$errors->get('price')" />
                </div>
                <br>

                <div class="mb-6">
                    <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                    <input @if (request()->routeIs('products.edit')) value="{{ old('stock', $product->stock) }}" @endif type="number" id="stock" name="stock" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Product Stock" required>
                    <x-input-error class="mt-2" :messages="$errors->get('stock')" />
                </div>
                <br>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="product_image">Upload image</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="product_image" id="product_image" name="image" type="file">
                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="product_image">A product picture is useful to grow your sell..</div>
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>
                <br>



                <button type="submit" class="  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    @if (request()->routeIs('products.edit')) 
                    Update
                    @else
                    Add 
                    @endif
                </button>
            </form>

    </div>
    </div>

    <br><br>



</x-app-layout>