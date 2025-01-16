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

        .containerTable{
            max-height: 300px;
            overflow: auto;

        }
    </style>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Create Products') }}
                    </h2>
                    <p class="pb-5">Complete the next form.</p>
                    <hr class="p-5">
                    <form id="createProductForm" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" placeholder="Product Name" name="name" class="input input-bordered w-full" />
                        <textarea class="textarea textarea-bordered w-full my-5" name="description" placeholder="Product Description..."></textarea>
                        <input type="number" placeholder="Product Price" name="price" class="input input-bordered w-full  " />
                        <input type="number" placeholder="Product Stock" name="stock" class="input input-bordered w-full mt-6" />

                        <div class="mt-6">
                            <span class="pb-5">Select at least one category</span>
                            <div class="containerTable">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                        <tr>
                                            <th>
                                                <label>
                                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="checkbox">
                                                </label>
                                            </th>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div>
                                                        <div class="font-bold">{{ $category->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-6">
                        <select class="select w-full max-w-xs" name="discount_type">
                            <option disabled selected>Discount Type</option>
                            <option value="percent">Percent</option>
                            <option value="fixed">Fixed</option>
                        
                        </select>
                        </div>

                        <input type="number" placeholder="Discount Value" name="discount_value" class="input input-bordered w-full mt-6" />



                        <div class="mt-6">
                        </div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload a Photo of the product</label>
                        <input name="imagen" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg 
                        cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="file_input_help" id="file_input" type="file" accept=".jpg, .jpeg, .png">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">JPEG, PNG or JPG (MAX. 800x400px).</p>

                        <x-primary-button class="mt-6">
                            {{ __('Save') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#createProductForm').submit(function(e) {
                e.preventDefault();

                let form = $('#createProductForm');
                var formData = new FormData(form[0]);

                console.log(formData);

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
                    url: "{{ route('products.store') }}",
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
                                    "{{ route('products.index') }}";
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