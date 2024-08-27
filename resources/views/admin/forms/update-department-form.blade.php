@extends('admin.layouts.common-form') @section('form-title')
    Update Department
    @endsection @section('form-content')
    <!-- Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Material to semester</h5>
                    <button type="button" id="" class="close hideAddFormModal" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="">

                        <input type="hidden" name="semester_id" id="semester_id">
                        <div class="form-group">
                            <label for="email">Assigned Materials</label>
                            <div class="shadow-lg p-3 bg-body rounded"
                                style="display: flex; flex-direction:column; max-height:20vh; overflow-y:auto"
                                id="existMaterialsOutput">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Assign New Materials</label>
                            <div class="field shadow-lg p-3 mb-5 bg-body rounded" style="max-height:30vh; overflow-y:auto">
                                <div style="display:flex;flex-direction:column;padding:5px;font-size: 15px"
                                    id="notAllocatedMaterialOutput">

                                </div>
                            </div>

                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger hideAddFormModal" data-dismiss="modal">Close</button>
                    <button type="button" id="submitAssignForm" class="btn btn-primary" disabled>Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @if ($data)
        <form action="{{ route('admin.update.department', $data->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="card-body" id="dynamicForm">
                <input type="hidden" name="" id="universityID" value="{{ $data->university_id }}">
                <input type="hidden" name="" id="departmentID" value="{{ $data->id }}">
                <div class="row shadow-lg p-3 mb-5 bg-ligth rounded m-1">
                    <div class="col-md-6 col-lg-10">
                        <div
                            class="form-group @error('university_id')
                    has-error
                    @enderror">
                            <label for="exampleFormControlSelect1">University Name</label>
                            <select class="form-select" name="university_id" id="selectUniversity">
                                <option value="{{ $data->university_id }}" selected>
                                    @isset($data->getUniversity->name)
                                        {{ $data->getUniversity->name }}
                                    @else
                                        Not allocated
                                    @endisset
                                </option>
                                @foreach ($universities as $university)
                                    @php
                                        if ($university->id == $data->university_id) {
                                            continue;
                                        }
                                    @endphp
                                    <option value="{{ $university->id }}">{{ $university->name }}</option>
                                @endforeach
                            </select>
                            @error('university_id')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group @error('department') has-error @enderror has-feedback">
                            <label for="email">Departmeny Name</label>
                            <input type="text" name="department" id="errorInput" value="{{ $data->department }}"
                                class="form-control" placeholder="Enter Department name (e.g- CSE)" />
                            @error('department')
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

                        <div class="form-group">
                            <b class="badge bg-primary my-2" style="font-size: 15px">Added Semesters</b>
                            <div class="col-6">
                                <input type="checkbox" style="width: 30px; height: 20px" class="my-2" id="selectAll" />
                                <b class="" style="" id="">Select all for delete</b>
                                <hr />
                                <div id="appendAfterInsert" class="my-1">
                                    @if ($data->getSemesters->count())
                                        @foreach ($data->getSemesters as $semester)
                                            <div class="d-flex">
                                                <input type="checkbox" value="{{ $semester->id }}" class="isCheck m-3"
                                                    id="" />
                                                <input type="text" name="semesters[]"
                                                    class="form-control semisterField" readonly
                                                    value="{{ $semester->semister_name }}" />
                                                <button type="button" class="badge bg-success m-3 editSemesterBtn">
                                                    Edit
                                                </button>


                                                <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn"
                                                    style="display: none" value="{{ $semester->id }}">
                                                    Save
                                                </button>
                                                <button type="button" class="badge bg-danger m-3 assignMaterials"
                                                    value="{{ $semester->id }}">
                                                    Assign Materials
                                                </button>
                                            </div>
                                            <div class="form-group" style="margin-left: 30px;color:chocolate">Assigned
                                                Materials {{ $semester->materials->count() }}
                                            </div>
                                            <br />
                                        @endforeach
                                    @else
                                        <p class="alert alert-danger" id="ifSemesterSNotExist">No semesters added yet!</p>
                                    @endif
                                </div>
                                <p id="checkedCount"></p>
                                <div id="switchBox"
                                    style="
                                position: relative;
                                left: -10px;
                                display: none;
                            ">
                                    <div class="form-check form-switch" style="margin-bottom: -20px">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="deleteMaterialsSwitch" style="transform: scale(1.2)" />
                                        <label class="form-check-label" for="deleteMaterialsSwitch"
                                            style="font-size: 1.2em">Deletes its related materials</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="deletePdfSwitch" style="transform: scale(1.2)" />
                                        <label class="form-check-label" for="deletePdfSwitch"
                                            style="font-size: 1.2em">Deletes
                                            its related pdfs</label>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-danger btn-sm" style="display: none"
                                    id="selectedDeleteBtn" value="{{ $data->university_id }}">
                                    Delete Selected
                                </button>
                                <button type="button" class="btn btn-dark btn-sm" id="addDynamicSemesterBtn">
                                    Add more
                                </button>
                                <div class="my-2" style="display: none" id="dynamicSemester">
                                    <div id="dynamicSemesterAppend"></div>
                                    <button id="saveNewSemesters" class="btn btn-success btn-sm my-1"
                                        value="{{ $data->id }}">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="checkOut"></div>
                        @isset($data->getUniversity->image)
                            <div class="form-group">
                                <img src="{{ asset('storage/' . $data->getUniversity->image) }}" height="225"
                                    width="300" alt="" srcset="" />
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-success">Update</button>
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

            const status = $("#status").val();
            const departmentID = $("#departmentID").val();
            // call ajax
            $.ajax({
                type: "POST",
                url: "{{ route('admin.ajax.status') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    id: departmentID,
                    key: "department",
                    status: status,
                },
                success: function(response) {
                    console.log(response);

                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr);
                },
            });
        })

        // show assign modal
        $(document).on("click", ".assignMaterials", function(e) {
            e.preventDefault();
            const semester_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('admin.assign.material') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    semester_id: semester_id,
                },
                success: function(response) {
                    console.log(response.notAllocatedMaterials);
                    let data = "";
                    let existData = "";
                    if (response.success) {
                        response.notAllocatedMaterials.forEach(element => {
                            data += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isMatCheck" type="checkbox" value=${element.id} role="switch"
                                                id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">${element.title} | ${element.get_pdf.length} pdfs found</label>
                                            
                                        </div>
                                    </div>`;
                        });
                        response.existMaterials.forEach(element => {
                            existData += `<div class="d-flex my-2" style="background: radial-gradient(circle at 100% 100%, #ffffff 0, #ffffff 4px, transparent 4px) 0% 0%/7px 7px no-repeat,
                            radial-gradient(circle at 0 100%, #ffffff 0, #ffffff 4px, transparent 4px) 100% 0%/7px 7px no-repeat,
                            radial-gradient(circle at 100% 0, #ffffff 0, #ffffff 4px, transparent 4px) 0% 100%/7px 7px no-repeat,
                            radial-gradient(circle at 0 0, #ffffff 0, #ffffff 4px, transparent 4px) 100% 100%/7px 7px no-repeat,
                            linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 6px) calc(100% - 14px) no-repeat,
                            linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 14px) calc(100% - 6px) no-repeat,
                            radial-gradient(#2ad10c 0%, #48abe0 100%);
                            border-radius: 7px;
                            padding: 8px;
                            box-sizing: border-box;">
                                <span>${element.title} | ${element.get_pdf.length} pdfs found</span>
                                <button class="badge bg-danger removeAssignedMaterial" value="${element.id}">Remove</button>
                                </div>`
                        });

                    }
                    if (existData == "") {
                        existData = `<p class="text-danger">No result found</p>`;

                    }
                    if (data == "") {
                        data = `<p class="text-danger">No result found</p>`;
                    }

                    $("#existMaterialsOutput").html(existData);
                    $("#notAllocatedMaterialOutput").html(data);
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr);
                },
            });
            $("#semester_id").val(semester_id);
            $("#assignModal").modal("show");
        })
        // hide assign modal
        $(document).on("click", ".hideAddFormModal", function(e) {
            e.preventDefault();
            $("#assignModal").modal("hide");
        })

        // removed assigned materials
        $(document).on("click", ".removeAssignedMaterial", function(e) {
            e.preventDefault();
            const id = $(this).val();
            const semester_id = $("#semester_id").val();
            const university_id = $("#universityID").val();
            const departmentId = $("#departmentID").val();

            $.ajax({
                type: "POST",
                url: "{{ route('ajax.not.assing.materials.semister') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    material_id: id,
                    semester_id: semester_id,
                    university_id: university_id,
                    department_id: departmentId,
                },
                success: function(response) {
                    let newData = "";
                    let notAllocatedData = "";
                    let newSemesterData = "";

                    console.log(response);
                    response.materials.forEach(element => {
                        newData += `<div class="d-flex my-2" style="background: radial-gradient(circle at 100% 100%, #ffffff 0, #ffffff 4px, transparent 4px) 0% 0%/7px 7px no-repeat,
                        radial-gradient(circle at 0 100%, #ffffff 0, #ffffff 4px, transparent 4px) 100% 0%/7px 7px no-repeat,
                        radial-gradient(circle at 100% 0, #ffffff 0, #ffffff 4px, transparent 4px) 0% 100%/7px 7px no-repeat,
                        radial-gradient(circle at 0 0, #ffffff 0, #ffffff 4px, transparent 4px) 100% 100%/7px 7px no-repeat,
                        linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 6px) calc(100% - 14px) no-repeat,
                        linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 14px) calc(100% - 6px) no-repeat,
                        radial-gradient(#2ad10c 0%, #48abe0 100%);
                        border-radius: 7px;
                        padding: 8px;
                        box-sizing: border-box;">
                                <span>${element.title} | ${element.get_pdf.length} pdfs found</span>
                                <button class="badge bg-danger removeAssignedMaterial" value="${element.id}">Remove</button>
                                </div>`;
                    });

                    response.notAllocated.forEach(element => {
                        notAllocatedData += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isMatCheck" type="checkbox" value=${element.id} role="switch"
                                                id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">${element.title} | ${element.get_pdf.length} pdfs found</label>
                                        </div>


                                    </div>`;
                    });

                    // collect all semesters data
                    response.semesters.forEach(value => {
                        newSemesterData += `<div class="d-flex">
                    <input type="checkbox" value="${value.id}" class="isCheck m-3" id="">
                    <input type="text" name="semesters[]" class="form-control semisterField" readonly value="${value.semister_name}">
                    <button type="button" class="badge bg-success m-3 editSemesterBtn">Edit</button>
                    <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn" style="display:none" value="${value.id}">Save</button>
                    <button type="button" class="badge bg-danger m-3 assignMaterials" value="${value.id}">Assign Materials</button>
                    </div>
                    <div class="form-group" style="margin-left: 30px;color:chocolate">Assigned
                    Materials ${value.materials.length} </div>
                    <br>`
                    });

                    if (newData == "") {
                        newData = `<p class="text-danger">No result found</p>`
                    }

                    if (notAllocatedData == "") {
                        notAllocatedData = `<p class="text-danger">No result found</p>`
                    }

                    if (newSemesterData == "") {
                        newSemesterData = `<p class="alert alert-danger">No semesters added yet!</p>`
                    }

                    $("#appendAfterInsert").html(newSemesterData);
                    $("#existMaterialsOutput").html(newData);
                    $("#notAllocatedMaterialOutput").html(notAllocatedData);
                }
            });
        });

        // enable assign material form submit btn
        $(document).on("click", ".isMatCheck", function(e) {
            const materials = [];
            $(".isMatCheck:checked").each(function() {
                materials.push($(this).val());
            });

            if (!jQuery.isEmptyObject(materials)) {
                $("#submitAssignForm").removeAttr('disabled');
            } else {
                $("#submitAssignForm").attr('disabled',
                    'disabled');
            }
        });

        // submit assigned materials form
        $(document).on("click", "#submitAssignForm", function(e) {
            e.preventDefault();
            const semesterId = $("#semester_id").val();
            const universityID = $("#universityID").val();
            const department_id = $("#departmentID").val();
            // Collect all  assigned materials id into an array
            const materials = [];
            $(".isMatCheck:checked").each(function() {
                materials.push($(this).val());
            });
            $.ajax({
                type: "POST",
                url: "{{ route('ajax.assing.materials.semister') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    university_id: universityID,
                    semester_id: semesterId,
                    department_id: department_id,
                    assignedMaterials: materials,
                },
                success: function(response) {
                    let newData = "";
                    let notAllocatedData = "";
                    let newSemesterData = "";

                    console.log(response.materials);
                    response.materials.forEach(element => {
                        newData += `<div class="d-flex my-2" style="background: radial-gradient(circle at 100% 100%, #ffffff 0, #ffffff 4px, transparent 4px) 0% 0%/7px 7px no-repeat,
                        radial-gradient(circle at 0 100%, #ffffff 0, #ffffff 4px, transparent 4px) 100% 0%/7px 7px no-repeat,
                        radial-gradient(circle at 100% 0, #ffffff 0, #ffffff 4px, transparent 4px) 0% 100%/7px 7px no-repeat,
                        radial-gradient(circle at 0 0, #ffffff 0, #ffffff 4px, transparent 4px) 100% 100%/7px 7px no-repeat,
                        linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 6px) calc(100% - 14px) no-repeat,
                        linear-gradient(#ffffff, #ffffff) 50% 50%/calc(100% - 14px) calc(100% - 6px) no-repeat,
                        radial-gradient(#2ad10c 0%, #48abe0 100%);
                        border-radius: 7px;
                        padding: 8px;
                        box-sizing: border-box;">
                                <span>${element.title} | ${element.get_pdf.length} pdfs found</span>
                                <button class="badge bg-danger removeAssignedMaterial" value="${element.id}">Remove</button>
                                </div>`;
                    });

                    response.notAllocated.forEach(element => {
                        notAllocatedData += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isMatCheck" type="checkbox" value=${element.id} role="switch"
                                                id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">${element.title} | ${element.get_pdf.length} pdfs found</label>
                                        </div>


                                    </div>`;
                    });

                    // collect all semesters data
                    response.semesters.forEach(value => {
                        newSemesterData += `<div class="d-flex">
                    <input type="checkbox" value="${value.id}" class="isCheck m-3" id="">
                    <input type="text" name="semesters[]" class="form-control semisterField" readonly value="${value.semister_name}">
                    <button type="button" class="badge bg-success m-3 editSemesterBtn">Edit</button>
                    <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn" style="display:none" value="${value.id}">Save</button>
                    <button type="button" class="badge bg-danger m-3 assignMaterials" value="${value.id}">Assign Materials</button>
                    </div>
                    <div class="form-group" style="margin-left: 30px;color:chocolate">Assigned
                    Materials ${value.materials.length} </div>
                    <br>`
                    });

                    if (newData == "") {
                        newData = `<p class="text-danger">No result found</p>`
                    }

                    if (notAllocatedData == "") {
                        notAllocatedData = `<p class="text-danger">No result found</p>`
                    }

                    if (newSemesterData == "") {
                        newSemesterData = `<p class="alert alert-danger">No semesters added yet!</p>`
                    }

                    $("#appendAfterInsert").html(newSemesterData);
                    $("#existMaterialsOutput").html(newData);
                    $("#notAllocatedMaterialOutput").html(notAllocatedData);

                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr)
                }
            });
        });

        // save semister edit
        $(document).on("click", ".cancelEditSemesterBtn", function(e) {
            e.preventDefault();
            const button = $(this);
            const id = button.val();
            const semester = button.siblings(".semisterField").val();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.update.semester') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    id: id,
                    semester: semester,
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

        // save new semesters
        $(document).on("click", "#saveNewSemesters", function(e) {
            e.preventDefault();
            const department_id = $(this).val();
            const university_id = $("#universityID").val();

            // Collect all the semester values into an array
            const semesters = [];
            $("input[name='newSemester[]']").each(function() {
                semesters.push($(this).val());
            });

            $.ajax({
                type: "POST",
                url: "{{ route('admin.ajax.new.semester') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    department_id: department_id,
                    university_id: university_id,
                    semesters: semesters,
                },
                success: function(response) {
                    $.each(response.data, function(indexInArray, valueOfElement) {
                        const newData = `
        <div class="d-flex">
        <input type="checkbox" value="${valueOfElement.id}" class="isCheck m-3" id="">
        <input type="text" name="semesters[]" class="form-control semisterField" readonly value="${valueOfElement.semister_name}">
        <button type="button" class="badge bg-success m-3 editSemesterBtn">Edit</button>
        <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn" style="display:none" value="${valueOfElement.id}">Save</button>
        <button type="button" class="badge bg-danger m-3 assignMaterials" value="${valueOfElement.id}">Assign Materials</button>
        </div>
        <div class="form-group" style="margin-left: 30px;color:chocolate">
            Assigned Materials 0 </div><br>`;

                        $("#ifSemesterSNotExist").hide();
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

        // delete selected semester
        $(document).on("click", "#selectedDeleteBtn", function(e) {
            e.preventDefault();
            let isDeleteMaterials = "off";
            let isDeletePdf = "off";
            // first check switched
            if ($("#deleteMaterialsSwitch").is(":checked")) {
                isDeleteMaterials = "on";
            }
            if ($("#deletePdfSwitch").is(":checked")) {
                isDeletePdf = "on";
            }
            // end

            const universityId = $(this).val();
            const departmentId = $("#departmentID").val();
            let id = [];
            $(".isCheck:checked").each(function() {
                id.push($(this).val());
            });

            if (jQuery.isEmptyObject(id)) {
                alert("Select a row to delete first!");
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.delete.semester.selected') }}",
                    data: {
                        _token: "{{ csrf_token() }}", // Include CSRF token
                        id: id,
                        universityId: universityId,
                        department_id: departmentId,
                        isDeleteMaterials: isDeleteMaterials,
                        isDeletePdf: isDeletePdf,
                    },
                    success: function(response) {
                        let newOutput = "";
                        $.each(response.newSemesterData, function(key, value) {
                            newOutput += `
                        <div class="d-flex">
                        <input type="checkbox" value="${value.id}" class="isCheck m-3" id="">
                        <input type="text" name="semesters[]" class="form-control semisterField" readonly value="${value.semister_name}">
                        <button type="button" class="badge bg-success m-3 editSemesterBtn">Edit</button>
                        <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn" style="display:none" value="${value.id}">Save</button>
                        <button type="button" class="badge bg-danger m-3 assignMaterials" value="${value.id}">Assign Materials</button>
                        </div>
                        <div class="form-group" style="margin-left: 30px;color:chocolate">Assigned
                        Materials ${value.materials.length} </div>
                        <br>`;
                        });

                        if (newOutput == "") {
                            newOutput = `<p class="alert alert-danger">No semesters added yet!</p>`
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
