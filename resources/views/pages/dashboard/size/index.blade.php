<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Size
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            // AJAX DATATABLE
            var dataTable = $('#crudTable').DataTable({
                ajax: {
                    url: "{!! url()->current() !!}",
                },
                columns: [
                    { data: 'id', name: 'id', width: '5%' },
                    { data: 'size', name: 'size', className: 'text-left'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '25%',
                        className: 'text-center'
                    },
                ],
            });
        </script>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- {{ dd($productCategories) }} --}}

            <div class="mb-10">
                <a href="{{ route('size.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                    + Create Size
                </a>
            </div>
            <!-- Success Message -->
            @if (session('success'))
                {{-- create success message --}}
                <div class="bg-green-500 text-white p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                {{-- create error message --}}
                <div class="bg-red-500 text-white p-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-4 py-6 bg-white sm:p-6">
                    <table id="crudTable" class="w-full table-auto">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Size</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                    <tbody></tbody>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
