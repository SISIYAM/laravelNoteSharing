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
