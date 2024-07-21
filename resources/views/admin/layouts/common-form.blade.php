@extends('admin.layouts.common')
@section('page-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @yield('form-title')
                </div>
                @yield('form-content')
            </div>
        </div>
    </div>
@endsection
@if (Session::has('success'))
    @push('sweet-alert')
        <script>
            swal("Success!", "{{ Session::get('success') }}", {
                icon: "success",
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
        </script>
    @endpush
@endif
