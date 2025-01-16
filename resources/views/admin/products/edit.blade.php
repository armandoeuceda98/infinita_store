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


        .dropdown-check-list {
            display: inline-block;
        }

        .dropdown-check-list .anchor {
            position: relative;
            cursor: pointer;
            display: inline-block;
            padding: 5px 50px 5px 10px;
            border: 1px solid #ccc;
        }

        .dropdown-check-list .anchor:after {
            position: absolute;
            content: "";
            border-left: 2px solid black;
            border-top: 2px solid black;
            padding: 5px;
            right: 10px;
            top: 20%;
            -moz-transform: rotate(-135deg);
            -ms-transform: rotate(-135deg);
            -o-transform: rotate(-135deg);
            -webkit-transform: rotate(-135deg);
            transform: rotate(-135deg);
        }

        .dropdown-check-list .anchor:active:after {
            right: 8px;
            top: 21%;
        }

        .dropdown-check-list ul.items {
            padding: 2px;
            display: none;
            margin: 0;
            border: 1px solid #ccc;
            border-top: none;
        }

        .dropdown-check-list ul.items li {
            list-style: none;
        }

        .dropdown-check-list.visible .anchor {
            color: #0094ff;
        }

        .dropdown-check-list.visible .items {
            display: block;
        }

        /* Style  check box try */
        .checkbox-wrapper-27 .checkbox {
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            border: none;
            /* Elimina bordes */
            border-radius: 0;
            /* Elimina bordes redondeados */
            background: none;
            /* Por si tiene un fondo aplicado */
            padding: 0;
            /* Por si el relleno está causando el efecto */
        }

        .checkbox-wrapper-27 .checkbox>input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            z-index: -1;
        }

        .checkbox-wrapper-27 .checkbox__icon {
            display: inline-block;
            color: #999;
            vertical-align: middle;
            margin-right: 5px;
        }

        .checkbox-wrapper-27 input[type="checkbox"]:checked~.checkbox__icon {
            color: #2A7DEA;
        }

        .checkbox-wrapper-27 .checkbox__icon:before {
            font-family: "icons-27";
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            /* Better Font Rendering =========== */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .checkbox-wrapper-27 .icon--check:before,
        .checkbox-wrapper-27 input[type="checkbox"]:checked~.checkbox__icon:before {
            content: "\e601";
        }

        .checkbox-wrapper-27 .icon--check-empty:before,
        .checkbox-wrapper-27 .checkbox__icon:before {
            content: "\e600";
        }

        @font-face {
            font-family: "icons-27";
            font-weight: normal;
            font-style: normal;
            src: url("data:application/x-font-woff;charset=utf-8;base64,d09GRk9UVE8AAAR4AAoAAAAABDAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABDRkYgAAAA9AAAAPgAAAD4fZUAVE9TLzIAAAHsAAAAYAAAAGAIIvy3Y21hcAAAAkwAAABMAAAATBpVzFhnYXNwAAACmAAAAAgAAAAIAAAAEGhlYWQAAAKgAAAANgAAADYAeswzaGhlYQAAAtgAAAAkAAAAJAPiAedobXR4AAAC/AAAABgAAAAYBQAAAG1heHAAAAMUAAAABgAAAAYABlAAbmFtZQAAAxwAAAE5AAABOUQYtNZwb3N0AAAEWAAAACAAAAAgAAMAAAEABAQAAQEBCGljb21vb24AAQIAAQA6+BwC+BsD+BgEHgoAGVP/i4seCgAZU/+LiwwHi2v4lPh0BR0AAAB8Dx0AAACBER0AAAAJHQAAAO8SAAcBAQgPERMWGyBpY29tb29uaWNvbW9vbnUwdTF1MjB1RTYwMHVFNjAxAAACAYkABAAGAQEEBwoNL2X8lA78lA78lA77lA6L+HQVi/yU+JSLi/iU/JSLBd83Fffsi4v77Pvsi4v37AUOi/h0FYv8lPiUi4v33zc3i/s3++yLi/fs9zeL398F9wCFFftN+05JzUdI9xr7GveR95FHzwUO+JQU+JQViwwKAAMCAAGQAAUAAAFMAWYAAABHAUwBZgAAAPUAGQCEAAAAAAAAAAAAAAAAAAAAARAAAAAAAAAAAAAAAAAAAAAAQAAA5gEB4P/g/+AB4AAgAAAAAQAAAAAAAAAAAAAAIAAAAAAAAgAAAAMAAAAUAAMAAQAAABQABAA4AAAACgAIAAIAAgABACDmAf/9//8AAAAAACDmAP/9//8AAf/jGgQAAwABAAAAAAAAAAAAAAABAAH//wAPAAEAAAAAAACkYCfgXw889QALAgAAAAAAz65FuwAAAADPrkW7AAD/4AIAAeAAAAAIAAIAAAAAAAAAAQAAAeD/4AAAAgAAAAAAAgAAAQAAAAAAAAAAAAAAAAAAAAYAAAAAAAAAAAAAAAABAAAAAgAAAAIAAAAAAFAAAAYAAAAAAA4ArgABAAAAAAABAA4AAAABAAAAAAACAA4ARwABAAAAAAADAA4AJAABAAAAAAAEAA4AVQABAAAAAAAFABYADgABAAAAAAAGAAcAMgABAAAAAAAKACgAYwADAAEECQABAA4AAAADAAEECQACAA4ARwADAAEECQADAA4AJAADAAEECQAEAA4AVQADAAEECQAFABYADgADAAEECQAGAA4AOQADAAEECQAKACgAYwBpAGMAbwBtAG8AbwBuAFYAZQByAHMAaQBvAG4AIAAxAC4AMABpAGMAbwBtAG8AbwBuaWNvbW9vbgBpAGMAbwBtAG8AbwBuAFIAZQBnAHUAbABhAHIAaQBjAG8AbQBvAG8AbgBHAGUAbgBlAHIAYQB0AGUAZAAgAGIAeQAgAEkAYwBvAE0AbwBvAG4AAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==") format("woff");
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
                        {{ __('Edit product') }}
                    </h2>
                    <p class="pb-5">Complete the next form.</p>
                    <hr class="p-5">
                    <form id="editProductForm" action="{{ route('products.update',  $product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" placeholder="Product Name" name="name" class="input input-bordered w-full" value="{{ $product->name }}" />
                        <textarea class="textarea textarea-bordered w-full my-5" name="description" placeholder="Product Description...">{{ $product->description }}</textarea>
                        <input type="text" placeholder="Product Price" name="price" class="input input-bordered w-full" value="{{ $product->price }}" />
                        <input type="text" placeholder="Product Stock" name="stock" class="input input-bordered w-full mt-6" value="{{ $product->stock }}" />

                        <!-- Aqui faltaria ver como mostrar las categorias ya seleccionadas  -->
                        <div class="mt-6">
                            <div id="categoriesList" class="dropdown-check-list">
                                <span class="anchor">Select Categories</span>
                                <ul class="items">
                                    @foreach ($categories as $category)
                                    <li>
                                        <div class="checkbox-wrapper-27">
                                            <label class="checkbox">
                                                <input type="checkbox" name="categories[]">
                                                <span class="checkbox__icon"></span>
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="mt-6">
                        </div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload a Photo of the product</label>
                        <input name="imagen" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg 
                        cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="file_input_help" id="file_input" type="file" accept=".jpg, .jpeg, .png">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">JPEG, PNG or JPG (MAX. 800x400px).</p>


                        <x-primary-button class="mt-6">
                            {{ __('Update') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // Evento submit del formulario
            $('#editProductForm').submit(function(e) {
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
                let variable = 0;

                let url = "{{ route('products.update', ':id') }}";

                $.ajax({
                    type: 'POST',
                    url: url,
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