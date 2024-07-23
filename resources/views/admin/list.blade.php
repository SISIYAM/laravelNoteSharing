@extends('admin.layouts.common-table')

@if ($key == 'university')
    @section('table-row')
        @php
            $count = 1;
        @endphp
        @foreach ($tableRow as $row)
            <tr>
                <td>{{ $count }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->semester }}</td>
                <td>{{ $row->author }}</td>
                <td>
                    @if ($row->status == 0)
                        <button class="badge bg-danger">Deactivated</button>
                    @else
                        <button class="badge bg-success">Active</button>
                    @endif
                </td>
                <td>
                    <div class="form-button-action">
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg"
                            data-original-title="Edit Task">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger"
                            data-original-title="Remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @php
                $count++;
            @endphp
        @endforeach
    @endsection
@elseif ($key == 'semester')
    @section('table-row')
        @php
            $count = 1;
        @endphp
        @foreach ($tableRow as $row)
            <tr>
                <td>{{ $count }}</td>
                <td>{{ $row->university->name }}</td>
                <td>{{ $row->semister_name }}</td>
                <td>{{ $row->author }}</td>
                <td>
                    @if ($row->status == 0)
                        <button class="badge bg-danger">Deactivated</button>
                    @else
                        <button class="badge bg-success">Active</button>
                    @endif
                </td>
                <td>
                    <div class="form-button-action">
                        <button type="button" data-bs-toggle="tooltip" title=""
                            class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger"
                            data-original-title="Remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @php
                $count++;
            @endphp
        @endforeach
    @endsection
@elseif ($key == 'materials')
    @section('table-row')
        @php
            $count = 1;
        @endphp
        @foreach ($tableRow as $row)
            <tr>
                <td>{{ $count }}</td>
                <td>{{ $row->getUniversity->name }}</td>
                <td>{{ $row->getSemester->semister_name }}</td>
                <td>{{ $row->title }}</td>
                <td>{{ $row->getAuthor->name }}</td>
                <td>
                    @if ($row->status == 0)
                        <button class="badge bg-danger">Deactivated</button>
                    @else
                        <button class="badge bg-success">Active</button>
                    @endif
                </td>
                <td>
                    <div class="form-button-action">
                        <a href="{{ route('admin.update.materials.form', $row->slug) }}"><button type="button"
                                data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg"
                                data-original-title="Edit Task">
                                <i class="fa fa-edit"></i>
                            </button></a>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger"
                            data-original-title="Remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @php
                $count++;
            @endphp
        @endforeach
    @endsection
@elseif ($key == 'faculties')
    @section('table-row')
        @foreach ($tableRow as $count => $row)
            <tr>
                <td>{{ $count + 1 }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->post }}</td>
                <td>{{ $row->author }}</td>
                <td>
                    @if ($row->status == 0)
                        <button class="badge bg-danger">Deactivated</button>
                    @else
                        <button class="badge bg-success">Active</button>
                    @endif
                </td>
                <td>
                    <div class="form-button-action">
                        <a href="{{ route('admin.form.update.faculties', $row->slug) }}"><button type="button"
                                data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg"
                                data-original-title="Edit Task">
                                <i class="fa fa-edit"></i>
                            </button></a>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger"
                            data-original-title="Remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    @endsection
@endif

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
