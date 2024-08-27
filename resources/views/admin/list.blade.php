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
                <td>{{ $row->getDepartments->count() }}</td>
                <td class="text-primary"> {{ $row->material->count() }} materials &
                    {{ $row->material->flatMap(function ($material) {
                            return $material->getPdf;
                        })->count() }}
                    pdfs
                </td>
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
                        <a href="{{ route('admin.form.update.university', $row->slug) }}">
                            <button type="button" data-bs-toggle="tooltip" title=""
                                class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                <i class="fa fa-edit"></i>
                            </button>
                        </a>
                        <button type="button" data-bs-toggle="tooltip" title=""
                            class="btn btn-link btn-danger deleteUniversityBtn" value="{{ $row->id }}"
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
                <td>{{ $row->title }}</td>
                <td>
                    <b
                        class="{{ count($row->getPdf) > 0 ? 'text-success' : 'text-danger' }}">{{ count($row->getPdf) }}</b>
                </td>
                <td>
                    @isset($row->getUniversity->name)
                        {{ $row->getUniversity->name }}
                    @else
                        <b class="text-danger"> Not Allocated</b>
                    @endisset

                </td>
                <td>
                    @isset($row->getSemester->getDepartment)
                        <a
                            href="{{ route('admin.manage.department.update', $row->getSemester->getDepartment->slug) }}">{{ $row->getSemester->getDepartment->department }}</a>
                    @else
                        <b class="text-danger"> Not Allocated</b>
                    @endisset
                </td>
                <td>
                    @isset($row->getSemester->semister_name)
                        <a
                            href="{{ route('admin.manage.department.update', $row->getSemester->getDepartment->slug) }}">{{ $row->getSemester->semister_name }}</a>
                    @else
                        <b class="text-danger"> Not Allocated</b>
                    @endisset
                </td>
                <td>
                    @isset($row->getAuthor->name)
                        {{ $row->getAuthor->name }}
                    @else
                        User not found!
                    @endisset
                </td>
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
                        <button type="button" data-bs-toggle="tooltip" title=""
                            class="btn btn-link btn-danger MaterialDeleteBtn" value="{{ $row->id }}"
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
                        <a href="{{ route('admin.delete.faculties', $row->slug) }}"
                            onclick="return confirm('Are you sure?')">
                            <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger"
                                data-original-title="Remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    @endsection
@elseif ($key == 'reviews')
    @section('table-row')
        @foreach ($tableRow as $count => $row)
            <tr>
                <td>{{ $count + 1 }}</td>
                <td>{!! isset($row->getPdf->title) ? $row->getPdf->title : `<b class="text-danger">Not Found!</b>` !!}</td>
                <td>{!! isset($row->getPdf->getMaterial->title)
                    ? $row->getPdf->getMaterial->title
                    : `<b class="text-danger">Not Found!</b>` !!}</td>
                <td>{{ $row->created_at->format('d M Y h:i A') }}</td>
                <td>{{ $row->rating }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->department }}</td>
                <td>{{ $row->batch }}</td>
                <td>{{ $row->review }}</td>


                <td>
                    <div class="form-button-action">
                        <a href="{{ route('admin.delete.reviews', $row->id) }}" onclick="return confirm('Are you sure?')">
                            <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger"
                                data-original-title="Remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    @endsection
@elseif ($key == 'pdfs')
    @section('table-row')
        @foreach ($tableRow as $count => $row)
            <tr>
                <td>{{ $count + 1 }}</td>
                <td>{{ $row->title }}</td>
                <td>
                    @isset($row->getMaterial->title)
                        <a href="{{ route('admin.update.materials.form', $row->getMaterial->slug) }}">
                            {{ $row->getMaterial->title }}
                        </a>
                    @else
                        <b class="text-danger">Not allocated</b>
                    @endisset

                </td>
                <td>
                    @isset($row->getMaterial->getSemester->getDepartment)
                        <a
                            href="{{ route('admin.manage.department.update', $row->getMaterial->getSemester->getDepartment->slug) }}">{{ $row->getMaterial->getSemester->getDepartment->department }}</a>
                    @else
                        <b class="text-danger">Not allocated</b>
                    @endisset
                </td>
                <td>{!! $row->type == 1 ? 'Pdf File' : 'Drive Link' !!}</td>
                <td>{{ $row->getAuthor->name }}</td>

                <td>
                    <div class="form-button-action">
                        <a href="{{ route('admin.delete.pdfs', $row->id) }}" onclick="return confirm('Are you sure?')">
                            <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger"
                                data-original-title="Remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    @endsection
@elseif ($key == 'departments')
    @section('table-row')
        @foreach ($tableRow as $count => $row)
            <tr>
                <td>{{ $count + 1 }}</td>
                <td>{{ $row->department }}</td>
                <td>{!! isset($row->getUniversity->name) ? $row->getUniversity->name : '<b class="text-danger">Not Allocated</b>' !!}</td>

                <td>{{ $row->getSemesters->count() }}</td>
                <td class="text-dark">
                    {{ $row->getSemesters->flatMap(function ($semester) {
                            return $semester->materials;
                        })->count() }}
                    Materials &
                    {{ $row->getSemesters->flatMap(function ($semester) {
                            return $semester->materials->flatMap(function ($material) {
                                return $material->getPdf;
                            });
                        })->count() }}
                    Pdfs
                </td>
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
                        <a href="{{ route('admin.manage.department.update', $row->slug) }}">
                            <button type="button" data-bs-toggle="tooltip" title=""
                                class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                <i class="fa fa-edit"></i>
                            </button>
                        </a>
                        @can('isAdmin')
                            <a href="{{ route('admin.delete.list.department', $row->id) }}"
                                onclick="return confirm('Are you sure?')">
                                <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger"
                                    data-original-title="Remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </a>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    @endsection
@elseif ($key == 'users')
    @section('table-row')
        @foreach ($tableRow as $count => $row)
            <tr>
                <td>{{ $count + 1 }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->email }}</td>

                <td>{!! $row->role === 2 ? 'Admin' : 'Modarator' !!}</td>
                <td>

                    <div class="containerSwitch">
                        @if ($row->status == 0)
                            <label class="custom-switch customSwitchLabel">
                                <input type="checkbox" class="customSwitchInput">
                                <span class="slider customSwitchSlider"></span>
                            </label>
                            <span class="badge badge-danger switchStatus">Deactivated</span>
                        @else
                            <label class="custom-switch customSwitchLabel">
                                <input type="checkbox" class="customSwitchInput" checked>
                                <span class="slider customSwitchSlider"></span>
                            </label>
                            <span class="badge badge-success switchStatus">Active</span>
                        @endif

                    </div>
                </td>
                <td>{{ $row->last_login ? $row->last_login->format('D m y h:i A') : 'not found' }}</td>

                <td>
                    <div class="form-button-action">
                        <button type="button" data-bs-toggle="tooltip" title=""
                            class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                            <i class="fa fa-edit"></i>
                        </button>
                        @can('isAdmin')
                            <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger"
                                data-original-title="Remove">
                                <i class="fa fa-times"></i>
                            </button>
                        @endcan
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

@if (Session::has('delete'))
    @push('sweet-alert')
        <script>
            swal("Deleted!", "{{ Session::get('delete') }}", {
                icon: "error",
                buttons: {
                    confirm: {
                        className: "btn btn-danger",
                    },
                },
            });
        </script>
    @endpush
@endif

@push('script')
    <script>
        // delete university
        $(document).on('click', '.deleteUniversityBtn', function() {

            const id = $(this).val();

            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                buttons: {
                    cancel: {
                        visible: true,
                        text: "No, cancel!",
                        className: "btn btn-danger",
                    },
                    confirm: {
                        text: "Yes, delete it!",
                        className: "btn btn-success",
                    },
                },
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('admin.delete.university') }}",
                        data: {
                            _token: "{{ csrf_token() }}", // Include CSRF token
                            id: id,
                        },

                        success: function(response) {
                            if (response.delete) {
                                swal(response.delete, {
                                    icon: "success",
                                    buttons: {
                                        confirm: {
                                            className: "btn btn-success",
                                        },
                                    },
                                }).then(() => {
                                    location.reload();
                                });
                            }
                            console.log(response);
                        }
                    });

                } else {
                    swal("Your imaginary file is safe!", {
                        buttons: {
                            confirm: {
                                className: "btn btn-success",
                            },
                        },
                    });
                }
            });

        });

        // delete Materials
        $('.MaterialDeleteBtn').on('click', function() {
            const id = $(this).val();

            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                buttons: {
                    cancel: {
                        visible: true,
                        text: "No, cancel!",
                        className: "btn btn-danger",
                    },
                    confirm: {
                        text: "Yes, delete it!",
                        className: "btn btn-success",
                    },
                },
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('admin.delete.materials') }}",
                        data: {
                            _token: "{{ csrf_token() }}", // Include CSRF token
                            id: id,
                        },

                        success: function(response) {
                            if (response.delete) {
                                swal(response.delete, {
                                    icon: "success",
                                    buttons: {
                                        confirm: {
                                            className: "btn btn-success",
                                        },
                                    },
                                }).then(() => {
                                    location.reload();
                                });
                            }
                            console.log(response);
                        }
                    });

                } else {
                    swal("Your imaginary file is safe!", {
                        buttons: {
                            confirm: {
                                className: "btn btn-success",
                            },
                        },
                    });
                }
            });



        });
    </script>
@endpush
