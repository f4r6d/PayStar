<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @forelse ($orders as $order)
                    <h2 class=" font-bold font-serif">Order #{{ $order->id }}:</h2>
                    <div id="{{ $order->id }}" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                        Product
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($order->products as $product)

                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        {{ $product->name }}
                                    </th>
                          
                                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                                        {{ $product->detail->quantity }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->price }} Rials
                                    </td>
                                </tr>

                                @endforeach

                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Total
                                    </th>
                                 
                                    <td class="px-6 py-4">
                                    </td>
                                    <td class="font-bold  px-6 py-4">
                                        {{ $order->amount }} Rials
                                    </td>
                                </tr>

                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Status
                                    </th>
                                   
                                    <td class="px-6 py-4">
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($order->payment->status)
                                        <p class="font-bold text-xl text-lime-700">Paid</p>
                                        @else
                                        <p class="font-bold text-xl text-red-700">Not Paid</p>
                                        @endif
                                    </td>
                                </tr>

                                @if ($order->payment->status)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Tracking Code
                                    </th>
                                   
                                    <td class="px-6 py-4">
                                    </td>
                                    <td class=" px-6 py-4">
                                        {{ $order->payment->tracking_code }}
                                    </td>
                                </tr>
                                @endif

                                @if ($order->payment->transaction_id)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Transaction ID
                                    </th>
                                  
                                    <td class="px-6 py-4">
                                    </td>
                                    <td class="font-bold px-6 py-4">
                                        {{ $order->payment->transaction_id }}
                                    </td>
                                </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>

                    <br><br>
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
            </div>
        </div>
    </div>
</x-app-layout>