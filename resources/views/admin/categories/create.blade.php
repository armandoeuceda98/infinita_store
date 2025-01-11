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
                    <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Create Category') }}
                    </h2>
                    <p class="pb-5">Complete the next form.</p>
                    <hr class="p-5">
                    <form id="createCategoryForm" action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" placeholder="Category Name" name="name" class="input input-bordered w-full" />
                        <textarea class="textarea textarea-bordered w-full my-5" name="description" placeholder="Category Description..."></textarea>
                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#createCategoryForm').submit(function(e) {
                e.preventDefault();

                let form = $(this);
                var formData = new FormData(form[0]);

                Swal.fire({
                    title: "Loading...",
                    html: "Please, wait...",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ route('categories.store') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.close();

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
                        
                        Swal.close();

                        Swal.fire(
                            'Error',
                            errors.message,
                            'error'
                        ).then((result) => {});
                    }
                });
            });
        });
    </script>
</x-app-layout>
