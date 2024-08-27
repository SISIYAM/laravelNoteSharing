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
    <!-- assign modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Departments</h5>
                    <button type="button" id="" class="close hideAssignModal" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="">

                        <input type="hidden" value="" id="userId">
                        <input type="hidden" value="" id="universityId">
                        <div class="form-group">
                            <label for="email">Assigned Departments</label>
                            <div class="shadow-lg p-3 bg-body rounded"
                                style="display: flex; flex-direction:column; max-height:20vh; overflow-y:auto"
                                id="assignedOutput">

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="shadow-lg p-3 bg-body rounded">
                                <label for="email">Filter University</label>
                                <select name="" class="form-select" id="filterUniversity">
                                    <option value="">Select University</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="email">Assign New Departments</label>
                            <div class="field shadow-lg p-3 mb-5 bg-body rounded"
                                style="max-height:30vh; overflow-y:auto">
                                <div style="display:flex;flex-direction:column;padding:5px;font-size: 15px"
                                    id="notAassignedOutput">

                                </div>
                            </div>

                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger hideAssignModal" data-dismiss="modal">Close</button>
                    <button type="button" id="submitAssignForm" class="btn btn-primary" disabled>Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End assign  modal -->
    @section('table-row')
        @foreach ($tableRow as $count => $row)
            @if ($row->id == $authUser->id)
                @continue;
            @endif
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
                            <span class="custmBadge badge-danger switchStatus">Deactivated</span>
                        @else
                            <label class="custom-switch customSwitchLabel">
                                <input type="checkbox" class="customSwitchInput" checked>
                                <span class="slider customSwitchSlider"></span>
                            </label>
                            <span class="custmBadge badge-success switchStatus">Active</span>
                        @endif

                    </div>
                </td>
                <td>{{ $row->last_login ? $row->last_login->format('D m y h:i A') : 'not found' }}</td>

                <td>
                    <div class="form-button-action">
                        <button value="{{ $row->id }}" type="button" data-bs-toggle="tooltip" title=""
                            class="btn btn-link btn-primary btn-lg showAssignDeptBtn" data-original-title="Edit Task">
                            <span class="badge bg-primary">assign</span>
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
        // assign departments to users modal code

        // show assign department modal
        $(document).on('click', '.showAssignDeptBtn', function(e) {
            e.preventDefault();
            const userId = $(this).val();
            $("#userId").val(userId);

            $.ajax({
                type: "POST",
                url: "{{ route('admin.load.filter.university') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    user_id: userId,
                },
                success: function(response) {
                    let university = "";
                    let departments = "";
                    let assignedDepartments = "";
                    console.log(response);
                    response.universities.forEach(element => {
                        university += `<option value="${element.id}">${element.name}</option>`;
                    });

                    response.universities[0].get_departments.forEach(value => {
                        departments += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isDepartmentCheck" type="checkbox" value=${value.id} role="switch"
                                                id="">
                                            <label class="form-check-label" for="">${value.department} </label>
                                        </div>
                                    </div>`
                    });

                    // loop for assigned departments
                    response.assignedDepartments.forEach(element => {
                        assignedDepartments += `<div class="d-flex my-2" style="background: radial-gradient(circle at 100% 100%, #ffffff 0, #ffffff 4px, transparent 4px) 0% 0%/7px 7px no-repeat,
                                radial-gradient(circle at 0 100%, #ffffff 0, #ffffff 4px, transparent 4px) 100% 0%/7px 7px no-repeat,
                                radial-gradient(circle at 100% 0, #ffffff 0, #ffffff 4px, transparent 4px) 0% 100%/7px 7px no-repeat,
                                radial-gradient(circle at 0 0, #ffffff 0, #ffffff 4px, transparent 4px) 100% 100%/7px 7px no-repeat,
                                linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 6px) calc(100% - 14px) no-repeat,
                                linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 14px) calc(100% - 6px) no-repeat,
                                radial-gradient(#2ad10c 0%, #48abe0 100%);
                                border-radius: 7px;
                                padding: 8px;
                                box-sizing: border-box;">
                                <span>${element.get_department.department}</span>
                                <button class="badge bg-danger removeAssignedDepartment" value="${element.id}">Remove</button>
                                </div>`

                    });

                    if (assignedDepartments == "") {
                        assignedDepartments = `<p class="
                        alert alert-danger ">No departments assigned yet!</p>`;
                    }

                    if (departments == "") {
                        departments = `<p class="
                        alert alert-danger ">No departments added yet!</p>`;
                    }

                    $("#assignedOutput").html(assignedDepartments);
                    $("#filterUniversity").html(university);
                    $("#notAassignedOutput").html(departments);

                    // assign first loaded university id into universityId field
                    $("#universityId").val(response.universities[0].id);
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr);
                },
            });

            $("#assignModal").modal('show');
        });

        // filter departments according to university
        $(document).on('change', '#filterUniversity', function(e) {
            e.preventDefault();
            const university_id = $(this).val();
            $("#universityId").val(university_id);
            const user_id = $("#userId").val();

            $.ajax({
                type: "POST",
                url: "{{ route('admin.filter.university.department') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    university_id,
                    user_id,

                },
                success: function(response) {
                    let departments = "";
                    response.departments.forEach(value => {
                        departments += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isDepartmentCheck" type="checkbox" value=${value.id} role="switch"
                                                id="">
                                            <label class="form-check-label" for="">${value.department} </label>
                                        </div>
                                    </div>`
                    });

                    if (departments == "") {
                        departments = `<p class="
                        alert alert-danger ">No departments added yet!</p>`;
                    }

                    $("#notAassignedOutput").html(departments);

                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr);
                },
            });
        })

        // enable assign departments form submit btn
        $(document).on("click", ".isDepartmentCheck", function(e) {
            const departments = [];
            $(".isDepartmentCheck:checked").each(function() {
                departments.push($(this).val());
            });

            if (!jQuery.isEmptyObject(departments)) {
                $("#submitAssignForm").removeAttr('disabled');
            } else {
                $("#submitAssignForm").attr('disabled',
                    'disabled');
            }
        });

        // submit assign department form
        $(document).on('click', '#submitAssignForm', function(e) {
            e.preventDefault();
            const user_id = $('#userId').val();
            const university_id = $("#universityId").val();

            // Collect all  assigned departments id into an array
            const departments = [];
            $(".isDepartmentCheck:checked").each(function() {
                departments.push($(this).val());
            });

            $.ajax({
                type: "POST",
                url: "{{ route('admin.ajax.assign.department') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    user_id,
                    departments,
                    university_id,
                },
                success: function(response) {
                    let assignedDepartments = "";
                    let departments = "";
                    console.log(response);
                    // loop for assigned departments
                    response.assignedDepartments.forEach(element => {
                        assignedDepartments += `<div class="d-flex my-2" style="background: radial-gradient(circle at 100% 100%, #ffffff 0, #ffffff 4px, transparent 4px) 0% 0%/7px 7px no-repeat,
                                radial-gradient(circle at 0 100%, #ffffff 0, #ffffff 4px, transparent 4px) 100% 0%/7px 7px no-repeat,
                                radial-gradient(circle at 100% 0, #ffffff 0, #ffffff 4px, transparent 4px) 0% 100%/7px 7px no-repeat,
                                radial-gradient(circle at 0 0, #ffffff 0, #ffffff 4px, transparent 4px) 100% 100%/7px 7px no-repeat,
                                linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 6px) calc(100% - 14px) no-repeat,
                                linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 14px) calc(100% - 6px) no-repeat,
                                radial-gradient(#2ad10c 0%, #48abe0 100%);
                                border-radius: 7px;
                                padding: 8px;
                                box-sizing: border-box;">
                                <span>${element.get_department.department}</span>
                                <button class="badge bg-danger removeAssignedDepartment" value="${element.id}">Remove</button>
                                </div>`

                    });

                    // loop for available departments
                    response.departments.forEach(value => {
                        departments += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isDepartmentCheck" type="checkbox" value=${value.id} role="switch"
                                                id="">
                                            <label class="form-check-label" for="">${value.department} </label>
                                        </div>
                                    </div>`
                    });

                    if (departments == "") {
                        departments = `<p class="
                        alert alert-danger ">No departments added yet!</p>`;
                    }



                    if (assignedDepartments == "") {
                        assignedDepartments = `<p class="
                        alert alert-danger ">No departments assigned yet!</p>`;
                    }

                    $("#notAassignedOutput").html(departments);
                    $("#assignedOutput").html(assignedDepartments)

                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr);
                },
            });
        })


        // removed assigned department
        $(document).on("click", ".removeAssignedDepartment", function(e) {
            e.preventDefault();
            const id = $(this).val();
            const user_id = $("#userId").val();
            const university_id = $("#universityId").val();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.remove.assigned.department') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    id,
                    user_id,
                    university_id,
                },
                success: function(response) {
                    let assignedDepartments = "";
                    let departments = "";
                    console.log(response);
                    // loop for assigned departments
                    response.assignedDepartments.forEach(element => {
                        assignedDepartments += `<div class="d-flex my-2" style="background: radial-gradient(circle at 100% 100%, #ffffff 0, #ffffff 4px, transparent 4px) 0% 0%/7px 7px no-repeat,
                                radial-gradient(circle at 0 100%, #ffffff 0, #ffffff 4px, transparent 4px) 100% 0%/7px 7px no-repeat,
                                radial-gradient(circle at 100% 0, #ffffff 0, #ffffff 4px, transparent 4px) 0% 100%/7px 7px no-repeat,
                                radial-gradient(circle at 0 0, #ffffff 0, #ffffff 4px, transparent 4px) 100% 100%/7px 7px no-repeat,
                                linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 6px) calc(100% - 14px) no-repeat,
                                linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 14px) calc(100% - 6px) no-repeat,
                                radial-gradient(#2ad10c 0%, #48abe0 100%);
                                border-radius: 7px;
                                padding: 8px;
                                box-sizing: border-box;">
                                <span>${element.get_department.department}</span>
                                <button class="badge bg-danger removeAssignedDepartment" value="${element.id}">Remove</button>
                                </div>`

                    });

                    // loop for available departments
                    response.departments.forEach(value => {
                        departments += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isDepartmentCheck" type="checkbox" value=${value.id} role="switch"
                                                id="">
                                            <label class="form-check-label" for="">${value.department} </label>
                                        </div>
                                    </div>`
                    });

                    if (departments == "") {
                        departments = `<p class="
                        alert alert-danger ">No departments added yet!</p>`;
                    }



                    if (assignedDepartments == "") {
                        assignedDepartments = `<p class="
                        alert alert-danger ">No departments assigned yet!</p>`;
                    }

                    $("#notAassignedOutput").html(departments);
                    $("#assignedOutput").html(assignedDepartments)
                }
            });
        });

        // hide assign department modal
        $(document).on('click', '.hideAssignModal', function(e) {
            e.preventDefault();
            $("#assignModal").modal('hide');
        })

        // assign departments to users modal code end


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
