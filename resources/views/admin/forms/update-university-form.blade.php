@extends('admin.layouts.common-form') @section('form-title')
    Update University
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
                                style="display: flex; flex-direction:column; max-height:20vh; overflow-y:hidden"
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
                    <button type="button" id="submitAssignForm" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @if ($data)
        <form action="{{ route('admin.update.university', $data->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="card-body" id="dynamicForm">
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
                            <select name="status" class="form-select">
                                @if ($data->status == 1)
                                    <option value="1" selected>Active</option>
                                    <option value="0">Deactivated</option>
                                @else
                                    <option value="1">Active</option>
                                    <option value="0" selected>Deactivated</option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group @error('description') has-error @enderror">
                            <label for="successInput">Description</label>
                            <textarea name="description" id="editor">{{ $data->description }}</textarea>
                            @error('description')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <b class="badge bg-primary my-2" style="font-size: 15px">Added Semesters</b>
                            <div class="col-6">
                                <input type="checkbox" style="width: 30px; height: 20px" class="my-2" id="selectAll" />
                                <b class="" style="" id="">Select all for delete</b>
                                <hr />
                                <div id="appendAfterInsert" class="my-1">
                                    @foreach ($data->semisters as $semester)
                                        <div class="d-flex">
                                            <input type="checkbox" value="{{ $semester->id }}" class="isCheck m-3"
                                                id="" />
                                            <input type="text" name="semesters[]" class="form-control semisterField"
                                                readonly value="{{ $semester->semister_name }}" />
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
                                        <br />
                                    @endforeach
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
                                    id="selectedDeleteBtn" value="{{ $data->id }}">
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
                        <div class="form-group @error('image') has-error @enderror has-feedback">
                            <label for="exampleFormControlFile1">University Logo (Dimensiond: 600x450 px)</label><br />
                            <input type="file" name="image" class="form-control-file"
                                id="exampleFormControlFile1" />
                            @error('image')
                                <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('storage/' . $data->image) }}" height="225" width="300"
                                alt="" srcset="" />
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
                                            <label class="form-check-label" for="flexSwitchCheckChecked">${element.title}</label>
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
                                <span>${element.title}</span>
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
            $.ajax({
                type: "POST",
                url: "{{ route('ajax.not.assing.materials.semister') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    material_id: id,
                    semester_id: semester_id,
                },
                success: function(response) {
                    let newData = "";
                    let notAllocatedData = "";
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
                                <span>${element.title}</span>
                                <button class="badge bg-danger removeAssignedMaterial" value="${element.id}">Remove</button>
                                </div>`;
                    });

                    response.notAllocated.forEach(element => {
                        notAllocatedData += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isMatCheck" type="checkbox" value=${element.id} role="switch"
                                                id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">${element.title}</label>
                                        </div>


                                    </div>`;
                    });

                    if (newData == "") {
                        newData = `<p class="text-danger">No result found</p>`
                    }

                    if (notAllocatedData == "") {
                        notAllocatedData = `<p class="text-danger">No result found</p>`
                    }

                    $("#existMaterialsOutput").html(newData);
                    $("#notAllocatedMaterialOutput").html(notAllocatedData);
                }
            });
        })

        // submit assigned materials form
        $(document).on("click", "#submitAssignForm", function(e) {
            e.preventDefault();
            const semesterId = $("#semester_id").val();

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
                    semester_id: semesterId,
                    assignedMaterials: materials,
                },
                success: function(response) {
                    let newData = "";
                    let notAllocatedData = "";
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
                                <span>${element.title}</span>
                                <button class="badge bg-danger removeAssignedMaterial" value="${element.id}">Remove</button>
                                </div>`;
                    });

                    response.notAllocated.forEach(element => {
                        notAllocatedData += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isMatCheck" type="checkbox" value=${element.id} role="switch"
                                                id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">${element.title}</label>
                                        </div>


                                    </div>`;
                    });

                    if (newData == "") {
                        newData = `<p class="text-danger">No result found</p>`
                    }

                    if (notAllocatedData == "") {
                        notAllocatedData = `<p class="text-danger">No result found</p>`
                    }

                    $("#existMaterialsOutput").html(newData);
                    $("#notAllocatedMaterialOutput").html(notAllocatedData);

                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr)
                }
            });
        })

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
            const id = $(this).val();

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
                    id: id,
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
        </div><br>`;

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
    </div><br>`;
                        });


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
