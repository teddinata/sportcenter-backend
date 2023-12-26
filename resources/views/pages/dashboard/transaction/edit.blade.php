<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Category &raquo; Edit
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
                {{-- {{ ($item)  }} --}}
                <form method="POST" action="{{ route('category.update', $item->id) }}" class="w-full" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="name" class="sr-only block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Category Name" class="appereance-none block leading-tight
                                focus:outline-none focus:bg-white bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') focus:border-gray-500
                                @enderror" value="{{ old('name') ?? $item->name }}">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 text-right">
                            <button type="submit" class="bg-green-500 text-white px-4 py-3 rounded font-medium w-full">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
