<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
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
                    // product_id
                    {
                        data: 'profile_photo_url',
                        name: 'profile_photo_url',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(profile_photo_url) {
                            return `<div class="text-center"><img src="${profile_photo_url}"  width="75px" /></div>`;
                        }
                    },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    {
                        data: 'roles',
                        name: 'roles',
                        className: 'text-center',
                        render: function(roles) {
                            return `<span class="uppercase px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-white-800">${roles}</span>`;
                        }
                    },
                    // { data: 'roles', name: 'roles' },
                    { data: 'last_login', name: 'last_login', className: 'text-center',
                        render: function(last_login) {
                            // if not null then format date
                            if (last_login) {
                                return moment(last_login).format('DD MMMM YYYY');
                            } else {
                                return '-';
                            }
                        }
                    },
                    // { data: 'status', name: 'status' },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        render: function(status) {
                            if (status == 'active') {
                                return `<span class="uppercase px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">${status}</span>`;
                            } else {
                                return `<span class="uppercase px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">${status}</span>`;
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
                <a href="{{ route('category.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                    + Create User
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
                                <th>Photo Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Last Login</th>
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
