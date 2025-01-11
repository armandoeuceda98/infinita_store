<x-app-layout>


    <style>
        @media only screen and (max-width: 767px) {
            table.table {
                border-spacing: -10px;

            }

            table.table td,
            table.table th {

                padding: 0;
                font-size: 12px;
                /* Ajusta el tamaño de fuente según tus necesidades */
            }

            .btn {
                font-size: 12px;
            }
        }
    </style>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Category List') }}
                        </h3>
                        <a href="{{ route('categories.create') }}">
                            <x-primary-button>{{ __('New Category') }}</x-primary-button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Description</th>
                                    <th style="text-align: end">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td style="text-align: end">
                                            <a href="{{ route('categories.edit', $category->id) }}">
                                                <x-primary-button>
                                                    {{ __('Edit') }}
                                                </x-primary-button>
                                            </a>
                                            @if ($category->status == 'active')
                                                <x-primary-button class="btn-change-status" data-id="{{ $category->id }}">
                                                    {{ __('Deactivate') }}
                                                </x-primary-button>
                                            @else
                                                <x-secondary-button class="btn-change-status" data-id="{{ $category->id }}">
                                                    {{ __('Activate') }}
                                                </x-secondary-button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let table = new DataTable('#table', {
                order: [
                    [1, 'asc']
                ]
            });

            $('#table').on('click', '.btn-change-status', function() {
                var id = $(this).data('id');
                let title = $(this).text() == 'Deactivate' ? 'Inactivating Category' : 'Activating Category';
                Swal.fire({
                    title: title,
                    text: "Are you sure you want to change the status of this category?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Confirm",
                    cancelButtonText: "Cancel",
                    customClass: {
                        confirmButton: 'bg-gray-800 text-white mx-2 px-4 py-2 rounded',
                        cancelButton: 'bg-gray-500 text-white mx-2 px-4 py-2 rounded'
                    },
                    showClass: {
                        popup: 'swal2-noanimation',
                        backdrop: 'swal2-noanimation'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ route('categories.changeStatus', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            type: 'get',
                            url: url,
                            success: function(response) {
                                Swal.fire(
                                    'Success',
                                    response.message,
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            "{{ route('categories.index') }}";
                                    }
                                });

                            },
                            error: function(xhr) {
                                var errors = xhr.responseJSON;
                                Swal.fire(
                                    'Error',
                                    response.message,
                                    'error'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            "{{ route('categories.index') }}";
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>
