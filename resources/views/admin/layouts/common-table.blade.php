@extends('admin.layouts.common')
@section('page-content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    @if ($key == 'university')
                        <h4 class="card-title">Universities</h4>
                        <a href="{{ route('admin.add.universities') }}"class="btn btn-primary btn-round ms-auto">
                            <i class="fa fa-plus"></i>
                            Add
                        </a>
                    @elseif ($key == 'materials')
                        <h4 class="card-title">Materials</h4>
                        <a href="{{ route('admin.form.materials') }}" class="btn btn-primary btn-round ms-auto">
                            <i class="fa fa-plus"></i>
                            Add
                        </a>
                    @elseif($key == 'faculties')
                        <h4 class="card-title">Faculties</h4>
                        <a href="{{ route('admin.form.faculties') }}" class="btn btn-primary btn-round ms-auto">
                            <i class="fa fa-plus"></i>
                            Add
                        </a>
                    @elseif ($key == 'departments')
                        <h4 class="card-title">Departments</h4>
                    @elseif ($key == 'pdfs')
                        <h4 class="card-title">Pdfs</h4>
                    @elseif ($key == 'users')
                        <h4 class="card-title">Users</h4>
                        <a href=""class="btn btn-primary btn-round ms-auto">
                            <i class="fa fa-plus"></i>
                            Add
                        </a>
                    @endif
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
