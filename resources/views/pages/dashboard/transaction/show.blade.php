<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction Details
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl smLrounded-lg p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <h3 class="text-2xl font-semibold mb-2">Transaction Information</h3>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-lg"><strong>Transaction ID:</strong> {{ $transaction->id }}</p>
                    <p class="text-lg"><strong>Buyer:</strong> {{ $transaction->user->name }}</p>
                    <p class="text-lg"><strong>Transaction Date:</strong> {{ $transaction->created_at->format('F d, Y, H:i:s') }}</p>
                    <p class="text-lg"><strong>Invoice Code:</strong> {{ $transaction->invoice_code }}</p>
                    <p class="text-lg"><strong>Total Price:</strong> Rp. {{ number_format($transaction->total_price, 2, ',', '.') }}</p>
                    <p class="text-lg"><strong>Shipping Price:</strong> Rp. {{ number_format($transaction->shipping_price, 2, ',', '.') }}</p>

                    <p class="text-lg"><strong>Payment Method:</strong> {{ $transaction->payment_method ?? '-' }}</p>
                    <p class="text-lg"><strong>Payment URL:</strong> {{ $transaction->payment_url ?? '-' }}</p>
                    <p class="text-lg"><strong>Status:</strong>
                        @if ($transaction->status == 'PENDING')
                            <span class="bg-yellow-500 text-white py-1 px-3 rounded-full text-sm">{{ $transaction->status }}</span>
                            @elseif ($transaction->status == 'SUCCESS')
                            <span class="bg-green-500 text-white py-1 px-3 rounded-full text-sm">{{ $transaction->status }}</span>
                            @elseif ($transaction->status == 'FAILED')
                            <span class="bg-red-500 text-white py-1 px-3 rounded-full text-sm">{{ $transaction->status }}</span>
                            @endif
                        </p>
                        <p class="text-xl font-semibold"><strong>Notes:</strong> {{ $transaction->notes ?? '-' }}</p>
                    <img src="{{ $transaction->details->first()->product->galleries->first()->url }}" alt="{{ $transaction->details->first()->product->name }}" class="mt-4 rounded-lg h-20">

                    <div class="mt-8">
                        <a href="{{ route('transactions.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to Transactions</a>
                    </div>
                    <div class="mt-8 border-t pt-8">
                        <h3 class="text-2xl font-semibold mb-4">Edit Transaction Status</h3>
                        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="flex items-center mb-4">
                                <label for="status" class="mr-2 text-lg">Status:</label>
                                <select name="status" id="status" class="border rounded p-2">
                                    <option value="PENDING" {{ $transaction->status === 'PENDING' ? 'selected' : '' }}>Pending</option>
                                    <option value="SUCCESS" {{ $transaction->status === 'SUCCESS' ? 'selected' : '' }}>Success</option>
                                    <option value="FAILED" {{ $transaction->status === 'FAILED' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-left">
                    <h3 class="text-lg font-semibold mb-6">Products Purchased</h3>
                    <div>
                        @foreach ($transaction->details as $detail)
                            <div class="bg-gray-100 p-6 rounded-lg">
                            <img src="{{ $detail->product->galleries->first()->url }}" alt="{{ $detail->product->name }}" class="rounded-lg" style="width: 300px">
                            <p class="text-xl font-semibold"><strong>{{ $detail->product->name }}</strong></p>
                            <p class="text-gray-700">Quantity: <strong>{{ $detail->quantity }}</strong></p>
                            <p class="text-gray-700">Subtotal:<strong> Rp. {{ number_format($detail->subtotal, 2, ',', '.') }}</strong></p>
                            {{-- size --}}
                             <p class="text-gray-700">Size:<strong> {{ $detail->product->sizes[0]->size }}</strong></p>
                            </div>
                        @endforeach
                    </div>

                </div>



            </div>







        </div>

    </div>
</x-app-layout>
