@extends('admin.layouts.common')
@section('page-content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">All</h4>
                    <button class="btn btn-primary btn-round ms-auto" id="modalShowBtn" data-bs-toggle="modal"
                        data-bs-target="#addFormModal">
                        <i class="fa fa-plus"></i>
                        Add
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="add-row" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                @foreach ($thead as $th)
                                    <th>{{ $th }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @yield('table-row')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
