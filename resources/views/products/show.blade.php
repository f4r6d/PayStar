<x-app-layout>
  <x-slot name="header">

    @can('viewAny', App\Models\Product::class)
    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
      {{ __('All Products') }}
    </x-nav-link>
    <x-nav-link :href="route('products.create')" :active="request()->routeIs('products.create')">
      {{ __('Add Product') }}
    </x-nav-link>
    @endcan

    @if (request()->routeIs('products.show'))
    <x-nav-link :href="route('products.show', $product)" :active="request()->routeIs('products.show', $product)">
      {{ $product->name }} Detail
    </x-nav-link>
    @endif



  </x-slot>


  <div class="container mx-auto">
    <br>
    <div class=" p-4 dark:text-slate-200 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">





      <!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    theme: {
      extend: {
        gridTemplateRows: {
          '[auto,auto,1fr]': 'auto auto 1fr',
        },
      },
    },
    plugins: [
      // ...
      require('@tailwindcss/aspect-ratio'),
    ],
  }
  ```
-->
      <div class="pt-6">

        <!-- Image gallery -->
        <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
          <div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
            <img style="filter: grayscale(100%) blur(5px);" src="{{ url('storage/'. ($product->image ?? 'default_image')) }}" alt="Two each of gray, white, and black shirts laying flat." class="h-full w-full object-cover object-center">
          </div>
          <div class="hidden lg:grid lg:grid-cols-1 lg:gap-y-8">
            <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg">
              <img style="filter: grayscale(30%) blur(2px);" src="{{ url('storage/'. ($product->image ?? 'default_image')) }}" alt="Model wearing plain black basic tee." class="h-full w-full object-cover object-center">
            </div>

          </div>
          <div class="aspect-h-5 aspect-w-4 lg:aspect-h-4 lg:aspect-w-3 sm:overflow-hidden sm:rounded-lg">
            <img src="{{ url('storage/'. ($product->image ?? 'default_image')) }}" alt="Model wearing plain white basic tee." class="h-full w-full object-cover object-center">
          </div>
        </div>

        <!-- Product info -->
        <div class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
          <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
            <h1 class="text-2xl font-bold tracking-tight dark:text-slate-200 text-gray-900 sm:text-3xl">{{$product->name}}</h1>
          </div>

          <!-- Options -->
          <div class="mt-4 lg:row-span-3 lg:mt-0">
            <h2 class="sr-only dark:text-slate-200">Product information</h2>
            <p class="text-3xl dark:text-slate-200 tracking-tight text-gray-900">{{$product->price}} Rials</p>




            <form action="{{ route('cart.add', $product->id) }}" method="get" class="mt-10">
              <!-- Colors -->
              <div>
                <h3 class="text-sm  dark:text-slate-200 font-medium text-gray-900">Color</h3>

                <fieldset class="mt-4">
                  <legend class="sr-only dark:text-slate-200">Choose a color</legend>
                  <div class="flex items-center space-x-3">
                    <!--
                  Active and Checked: "ring ring-offset-1"
                  Not Active and Checked: "ring-2"
                -->
                    <label class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none ring-gray-400">
                      <input type="radio" name="color-choice" value="White" class="sr-only" aria-labelledby="color-choice-0-label">
                      <span id="color-choice-0-label" class="sr-only">White</span>
                      <span aria-hidden="true" class="h-8 w-8 bg-white rounded-full border border-black border-opacity-10"></span>
                    </label>
                    <!--
                  Active and Checked: "ring ring-offset-1"
                  Not Active and Checked: "ring-2"
                -->
                    <label class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none ring-gray-400">
                      <input type="radio" name="color-choice" value="Gray" class="sr-only" aria-labelledby="color-choice-1-label">
                      <span id="color-choice-1-label" class="sr-only">Gray</span>
                      <span aria-hidden="true" class="h-8 w-8 bg-gray-500 rounded-full border border-black border-opacity-10"></span>
                    </label>
                    <!--
                  Active and Checked: "ring ring-offset-1"
                  Not Active and Checked: "ring-2"
                -->
                    <label class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none ring-gray-900">
                      <input type="radio" name="color-choice" value="Black" class="sr-only" aria-labelledby="color-choice-2-label">
                      <span id="color-choice-2-label" class="sr-only">Black</span>
                      <span aria-hidden="true" class="h-8 w-8  bg-slate-900 rounded-full border border-black border-opacity-10"></span>
                    </label>
                  </div>
                </fieldset>
              </div>





              <button type="submit" class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-cyan-600 px-8 py-3 text-base font-medium text-white hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">Add to Cart</button>
            </form>
          </div>

          <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
            <!-- Description and details -->
            <div>
              <h3 class="sr-only dark:text-slate-100">Description</h3>

              <div class="space-y-6">
                <p class="text-base dark:text-slate-200 text-gray-900">{{ $product->description }}</p>
              </div>
            </div>




          </div>
        </div>
      </div>




    </div>
  </div>

  <br><br>



</x-app-layout>