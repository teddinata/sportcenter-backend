<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transactions
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
                    { data: 'user.name', name: 'user.name', className: 'text-left'},
                    { data: 'product', name: 'product', className: 'text-left'},
                    // transaction date format use carbon
                    { data: 'created_at', name: 'created_at', className: 'text-left',
                        render: function(data) {
                            return moment(data).format('DD MMMM YYYY' + ' ' + 'HH:mm:ss');
                        }
                    },
                    { data: 'invoice_code', name: 'invoice_code', className: 'text-left'},
                    // format number to currency
                    { data: 'total_price', name: 'total_price', className: 'text-right',
                        render: $.fn.dataTable.render.number(',', '.', 2, 'Rp. ')
                    },
                    // status badge
                    { data: 'status', name: 'status', className: 'text-center',
                        render: function(data) {
                            if (data == 'PENDING') {
                                return '<span class="bg-yellow-500 text-white py-1 px-3 rounded-full text-xs">' + data + '</span>';
                            }
                            if (data == 'SUCCESS') {
                                return '<span class="bg-green-500 text-white py-1 px-3 rounded-full text-xs">' + data + '</span>';
                            }
                            if (data == 'FAILED') {
                                return '<span class="bg-red-500 text-white py-1 px-3 rounded-full text-xs">' + data + '</span>';
                            }
                        }
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '15%',
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
                {{-- <a href="{{ route('category.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                    + Create User
                </a> --}}
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
                                <th>Buyer</th>
                                <th>Product</th>
                                <th>Transaction Date</th>
                                <th>Invoice</th>
                                <th>Total Price</th>
                                <th>Status</th>
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
