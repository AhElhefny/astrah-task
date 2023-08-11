<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />

    <style>
        body {
            background-color: white;
        }
    </style>

</head>

<body>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="container">
                <div class="row">

                    <div class="col-12 pt-2">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title text-center">Import Data
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    {{-- <form method="POST" action="{{ route('import-file') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label class="">Choose Excel File</label>
                                            <input type="file" name="file" class="form-control" />
                                            @error('file')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <input type="submit" name="Import" class="btn btn-info" />
                                        </div>
                                    </form> --}}

                                    <form method="POST" action="{{ route('import-file') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label class="">Choose Excel File</label>
                                            <input type="file" name="file" id="excel_file" class="form-control" />
                                            <span class="text text-danger d-none file"></span>
                                        </div>
                                        <div style="display: flex;justify-content: space-evenly;">
                                            <div>
                                                <label for="full_name">Full Name:</label>
                                                <select class="columns form-control" name="column_mappings[full_name]">
                                                    <option seleced>Select Column</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="phone_number">Phone Number:</label>
                                                <select class="columns form-control"
                                                    name="column_mappings[phone_number]">
                                                    <option seleced>Select Column</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="email">Email:</label>
                                                <select class="columns form-control" name="column_mappings[email]">
                                                    <option seleced>Select Column</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Import</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    @if (session('success') || session('danger'))
                        <x-message message="{{ session('success') ? 'success' : 'danger' }}" />
                    @endif
                    <div class="col-12 pt-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title text-center">All Data
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>ID</th>
                                                    <th>Full Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Email</th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr class="text-center">
                                                        <td>{{ $user->id }}</td>
                                                        <td>{{ $user->full_name }}</td>
                                                        <td>{{ $user->phone_number }}</td>
                                                        <td>{{ $user->email }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('#excel_file').change(function(e) {
                e.preventDefault();

                let formData = new FormData();
                formData.append('file', $(this)[0].files[0])

                $.ajax({
                    url: '{{ route('get-headings') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function({
                        columns
                    }) {
                        $('.columns').empty().append(
                            '<option seleced disabled>Select Column</option>')
                        columns.forEach((column) => {
                            $('.columns').append(
                                `<option value="${column}">${column}</option>`)

                        })
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        $('.file').removeClass('d-none');
                        $('.file').text(xhr.responseJSON.message);
                        // alert(xhr.responseJSON.message)
                    }
                });
            });
        });
    </script>
</body>

</html>
