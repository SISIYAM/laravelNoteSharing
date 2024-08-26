@extends('admin.layouts.common-form') @section('form-title')
    Update University
    @endsection @section('form-content')
    @if ($data)
        <form action="{{ route('admin.update.university', $data->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="card-body" id="dynamicForm">
                <input type="hidden" name="" id="universityID" value="{{ $data->id }}">
                <div class="row shadow-lg p-3 mb-5 bg-ligth rounded m-1">
                    <div class="col-md-6 col-lg-10">
                        <div class="form-group @error('name') has-error @enderror has-feedback">
                            <label for="email">University Name</label>
                            <input type="text" name="name" id="errorInput" value="{{ $data->name }}"
                                class="form-control" placeholder="Enter university name (e.g- BSMRAAU)" />
                            @error('name')
                                <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <div class="form-check form-switch">
                                <input style="transform: scale(2);" class="form-check-input" type="checkbox" role="switch"
                                    id="statusSwitch" {{ $data->status == 1 ? 'checked' : '' }}>
                            </div>
                            <input type="hidden" name="status" id="status"
                                value="{{ $data->status == 1 ? '1' : '0' }}">

                        </div>

                        <div class="form-group @error('description') has-error @enderror">
                            <label for="successInput">Description</label>
                            <textarea name="description" id="editor">{{ $data->description }}</textarea>
                            @error('description')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group">
                            <h2 class="badge bg-primary" style="font-size: 15px">Departments</h2>
                            <div class="col-6">
                                <input type="checkbox" style="width: 30px; height: 20px" class="my-2" id="selectAll" />
                                <b class="" style="" id="">Select all for delete</b>
                                <hr />
                                <div id="appendAfterInsert" class="my-1">
                                    @if ($data->getDepartments->count())
                                        @foreach ($data->getDepartments as $department)
                                            <div class="d-flex">
                                                <input type="checkbox" value="{{ $department->id }}" class="isCheck m-3"
                                                    id="" />
                                                <input type="text" name="" class="form-control semisterField"
                                                    readonly value="{{ $department->department }}" />
                                                <button type="button" class="badge bg-success m-3 editSemesterBtn">
                                                    Edit
                                                </button>


                                                <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn"
                                                    style="display: none" value="{{ $department->id }}">
                                                    Save
                                                </button>

                                            </div>
                                            <div class="form-group" style="margin-left: 30px;color:chocolate">
                                                Assigned Semesters
                                                {{ $data->getDepartments->flatMap(function ($department) {
                                                        return $department->getSemesters;
                                                    })->count() }}

                                            </div>
                                            <br />
                                        @endforeach
                                    @else
                                        <p class="alert alert-danger" id="ifDepartmentdExist">No Departments added yet!
                                        </p>
                                    @endif
                                </div>
                                <p id="checkedCount"></p>

                                <button type="button" class="btn btn-danger btn-sm" style="display: none"
                                    id="selectedDeleteBtn" value="{{ $data->id }}">
                                    Delete Selected
                                </button>
                                <button type="button" class="btn btn-dark btn-sm" id="addDynamicSemesterBtn">
                                    Add more
                                </button>
                                <div class="my-2" style="display: none" id="dynamicSemester">
                                    <div id="dynamicSemesterAppend"></div>
                                    <button id="saveNewDepartments" class="btn btn-success btn-sm my-1"
                                        value="{{ $data->id }}">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="checkOut"></div>
                        <div class="form-group @error('image') has-error @enderror has-feedback">
                            <label for="exampleFormControlFile1">University Logo (Dimensiond: 600x450 px)</label><br />
                            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" />
                            @error('image')
                                <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('storage/' . $data->image) }}" height="225" width="300" alt=""
                                srcset="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-danger">Cancel</button>
            </div>
        </form>
    @endif
@endsection
@push('ajax')
    <script>
        // handle status switch
        $(document).on("click", "#statusSwitch", function(e) {
            if ($("#statusSwitch").is(':checked')) {
                $("#status").val(1);
            } else {
                $("#status").val(0);
            }
        })

        // save departments edit
        $(document).on("click", ".cancelEditSemesterBtn", function(e) {
            e.preventDefault();
            const button = $(this);
            const department_id = button.val();
            const department = button.siblings(".semisterField").val();
            const universityID = $("#universityID").val();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.ajax.update.department') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    university_id: universityID,
                    department_id: department_id,
                    department: department,
                },
                success: function(response) {
                    if (response.success) {
                        button.siblings("input").prop("readonly", true);
                        button.hide();
                        button.siblings(".editSemesterBtn").show();
                    }
                    console.log(response);
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr);
                },
            });
        });

        // save new departments
        $(document).on("click", "#saveNewDepartments", function(e) {
            e.preventDefault();
            const university_id = $(this).val();

            // Collect all the departments values into an array
            const departments = [];
            $("input[name='newSemester[]']").each(
                function() { // here i use same code for semester and departments so thats why for semester and department has same input field name newSemesters in script.js
                    departments.push($(this).val());
                });

            $.ajax({
                type: "POST",
                url: "{{ route('admin.ajax.add.department') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    university_id: university_id,
                    departments: departments,
                },
                success: function(response) {
                    console.log(response)
                    $.each(response.data, function(indexInArray, valueOfElement) {
                        const newData = `
        <div class="d-flex">
        <input type="checkbox" value="${valueOfElement.id}" class="isCheck m-3" id="">
        <input type="text" name="" class="form-control semisterField" readonly value="${valueOfElement.department}">
        <button type="button" class="badge bg-success m-3 editSemesterBtn">Edit</button>
        <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn" style="display:none" value="${valueOfElement.id}">Save</button>
        </div>
        <div class="form-group" style="margin-left: 30px;color:chocolate">
                        Assigned Semesters 0 </div>
        <br>`;

                        $("#ifDepartmentdExist").hide();
                        $("#appendAfterInsert").append(newData);
                        $("#dynamicSemester").hide();
                        $("#dynamicSemesterAppend").empty();
                    });
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr);
                },
            });
        });

        // delete selected departments
        $(document).on("click", "#selectedDeleteBtn", function(e) {
            e.preventDefault();

            const universityId = $(this).val();
            let id = [];
            $(".isCheck:checked").each(function() {
                id.push($(this).val());
            });

            if (jQuery.isEmptyObject(id)) {
                alert("Select a row to delete first!");
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.delete.department.selected') }}",
                    data: {
                        _token: "{{ csrf_token() }}", // Include CSRF token
                        id: id,
                        universityId: universityId,
                    },
                    success: function(response) {
                        let newOutput = "";
                        $.each(response.newDepartmentData, function(key, value) {
                            newOutput += `
                        <div class="d-flex">
                        <input type="checkbox" value="${value.id}" class="isCheck m-3" id="">
                        <input type="text" name="" class="form-control semisterField" readonly value="${value.department}">
                        <button type="button" class="badge bg-success m-3 editSemesterBtn">Edit</button>
                        <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn" style="display:none" value="${value.id}">Save</button>
                        </div>
                        <div class="form-group" style="margin-left: 30px;color:chocolate">
                        Assigned Semesters ${value.get_semesters.length} </div>
                        <br>`;
                        });

                        if (newOutput == "") {
                            newOutput = `<p class="alert alert-danger">No Departments added yet!</p>`
                        }

                        $("#appendAfterInsert").html(newOutput);
                        $("#selectedDeleteBtn").hide();
                        $("#checkedCount").html("");
                        console.log(response);
                    },
                });
            }
        });
    </script>
@endpush
