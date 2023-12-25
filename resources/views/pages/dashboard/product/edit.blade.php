<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product &raquo; Create
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                {{-- create error message --}}
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 mb-4">
                        <div class="font-bold">Oops! Something went wrong.</div>
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('product.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="name" class="sr-only block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Name</label>
                            <input type="text" name="name" id="name" placeholder="Product Name" class="appereance-none block leading-tight focus:outline-none focus:bg-white bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') focus:border-gray-500 @enderror" value="{{ old('name', $product->name) }}">
                        </div>

                        <div class="w-full md:w-1/2 px-3">
                            <label for="description" class="sr-only block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Description</label>
                            <textarea name="description" id="description" placeholder="Product Description" class="appereance-none block leading-tight focus:outline-none focus:bg-white bg-gray-100 border-2 w-full p-4 rounded-lg @error('description') focus:border-gray-500 @enderror">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="price" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Price</label>
                            <input type="number" name="price" id="price" placeholder="Product Price" value="{{ old('price', $product->price) }}" class="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                            <p class="text-gray-600 text-xs italic">Current price: {{ number_format(old('price', $product->price), 0, ',', '.') }}</p>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="stock" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Stock</label>
                            <input type="number" name="stock" id="stock" placeholder="Product Stock" value="{{ old('stock', $product->stock) }}" class="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3">
                            <label for="product_category_id" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Category</label>
                            <select name="product_category_id" id="product_category_id" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->product_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full md:w-1/2 px-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Status</label>
                            <select name="status" id="status" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Available</option>
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="tags" class="sr-only block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Tags</label>
                            <input type="text" name="tags" id="tags" placeholder="Product Tags" value="{{ old('tags', $product->tags) }}" class="appereance-none block leading-tight focus:outline-none focus:bg-white bg-gray-100 border-2 w-full p-4 rounded-lg @error('tags') focus:border-gray-500 @enderror">
                            <p class="text-gray-600 text-xs italic">Comma separated, e.g: tag1, tag2, tag3</p>
                        </div>
                    </div>

                    {{-- size --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="size" class="sr-only block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Size</label>
                            <input type="text" name="size" id="size" placeholder="Product Size" value="{{ old('size', $product->size) }}" class="appereance-none block leading-tight focus:outline-none focus:bg-white bg-gray-100 border-2 w-full p-4 rounded-lg @error('size') focus:border-gray-500 @enderror">
                            <p class="text-gray-600 text-xs italic">Comma separated, e.g: size1, size2, size3</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <script>
        // Get the price input field
        var priceInput = document.getElementById('price');

        // Function to add thousand separator
        function addThousandSeparator(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Function to remove thousand separator
        function removeThousandSeparator(value) {
            return value.replace(/\./g, "");
        }

        // Add thousand separator when the input field loses focus
        priceInput.addEventListener('blur', function() {
            var value = removeThousandSeparator(priceInput.value);
            priceInput.value = addThousandSeparator(value);
        });

        // Remove thousand separator when the input field is focused
        priceInput.addEventListener('focus', function() {
            var value = removeThousandSeparator(priceInput.value);
            priceInput.value = value;
        });
    </script> --}}
</x-app-layout>
