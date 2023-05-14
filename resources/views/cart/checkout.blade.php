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

                    <h1 class="mb-10 text-center text-2xl font-bold">Checkout</h1>
                    <div class="mx-auto  max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
                        <div class="rounded-lg md:w-2/3">

                            <div class="justify-between mb-6 rounded-lg bg-white  dark:bg-gray-700 p-6 shadow-md sm:flex sm:justify-start">
                                <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                                    <div class="mt-5 sm:mt-0">
                                        <h2 class="text-lg font-bold text-slate-800 dark:text-gray-100">{{ auth()->user()->name }}</h2>
                                        <br>

                                        <form method="post" action="{{ route('profile.update-card-number') }}" class="w-full max-w-sm">
                                            @csrf
                                            @method('patch')
                                            <label class="font-bold" for="card_number">Card Number</label>
                                            <div id="card_number" class="flex items-center border-b border-teal-500 py-2">
                                                <input type="test" name="card_number" class="appearance-none font-bold dark:text-gray-100  bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" value="{{ preg_replace('~.{4}\K~', '  ', auth()->user()->card_number) }}" aria-label="Card Number">
                                                <input type="submit" class=" text-teal-500" value="Change">
                                            </div>
                                            <x-input-error class="mt-2" :messages="$errors->get('card_number')" />
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('cart.subtotal')

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>