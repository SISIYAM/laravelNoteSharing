@extends('admin.layouts.common-form')
@section('form-title')
    Update University
@endsection
@section('form-content')
    @if ($data)
        <form action="{{ route('admin.update.university', $data->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body" id="dynamicForm">
                <div class="row shadow-lg p-3 mb-5 bg-ligth rounded m-1">
                    <div class="col-md-6 col-lg-10">

                        <div
                            class="form-group @error('name')
                            has-error
                            @enderror  has-feedback">
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

                        <div class="form-group  @error('description')
              has-error
            @enderror">
                            <label for="successInput">Description</label>
                            <textarea name="description" id="editor">{{ $data->description }}</textarea>
                            @error('description')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <b class="badge bg-primary my-2" style="font-size:15px">Added Semesters</b>
                            <div class="col-6">

                                <input type="checkbox" style="width: 30px; height: 20px;" class="my-2" id="selectAll">
                                <b class="" style="" id="">Select
                                    all for delete</b>
                                <hr>
                                <div id="appendAfterInsert" class="my-1">
                                    @foreach ($data->semisters as $semester)
                                        <div class="d-flex">
                                            <input type="checkbox" value="{{ $semester->id }}" class="isCheck m-3"
                                                id="">
                                            <input type="text" name="semesters[]" class="form-control semisterField"
                                                readonly value="{{ $semester->semister_name }}">
                                            <button type="button"
                                                class="badge bg-success m-3 editSemesterBtn">Edit</button>

                                            <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn"
                                                style="display:none" value="{{ $semester->id }}">Save</button>
                                        </div><br>
                                    @endforeach
                                </div>
                                <p id="checkedCount"></p>
                                <button type="button" class="btn btn-danger btn-sm" style="display: none"
                                    id="selectedDeleteBtn" value="{{ $data->id }}">Delete
                                    Selected</button>
                                <button type="button" class="btn btn-dark btn-sm" id="addDynamicSemesterBtn">Add
                                    more</button>
                                <div class="my-2" style="display: none" id="dynamicSemester">

                                    <div id="dynamicSemesterAppend"></div>
                                    <button id="saveNewSemesters" class="btn btn-success btn-sm my-1"
                                        value="{{ $data->id }}">Save</button>
                                </div>
                            </div>
                        </div>
                        <div id="checkOut">

                        </div>
                        <div
                            class="form-group @error('image')
                            has-error
                            @enderror  has-feedback">
                            <label for="exampleFormControlFile1">University Logo (Dimensiond: 600x450 px)</label><br>
                            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" />
                            @error('image')
                                <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('storage/' . $data->image) }}" height="225" width="300" alt=""
                                srcset="">
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
        // save semister edit
        $(document).on("click", ".cancelEditSemesterBtn", function(e) {
            e.preventDefault();
            const button = $(this);
            const id = button.val();
            const semester = button.siblings('.semisterField').val();
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
                    console.log(xhr)
                }
            });

        });

        // save new semesters
        $(document).on('click', '#saveNewSemesters', function(e) {
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
                        const newData = `<div class="d-flex">
                                            <input type="checkbox" value="` + valueOfElement.id + `" class="isCheck m-3"
                                                id="">
                                            <input type="text" name="semesters[]" class="form-control semisterField" readonly
                                                value="` + valueOfElement.semister_name + `">
                                            <button type="button"
                                                class="badge bg-success m-3 editSemesterBtn">Edit</button>
                                            
                                            <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn"
                                                style="display:none" value="` + valueOfElement.id + `">Save</button>
                                        </div><br>`;
                        $('#appendAfterInsert').append(newData);
                        $('#dynamicSemester').hide();
                        $('#dynamicSemesterAppend').empty();
                    });
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr)
                }
            });

        });

        // delete selected semester
        $(document).on('click', '#selectedDeleteBtn', function(e) {
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
                    url: "{{ route('admin.delete.semester.selected') }}",
                    data: {
                        _token: "{{ csrf_token() }}", // Include CSRF token
                        id: id,
                        universityId: universityId,
                    },
                    success: function(response) {
                        let newOutput = "";
                        $.each(response.newSemesterData, function(key, value) {
                            newOutput += `<div class="d-flex">
                                            <input type="checkbox" value="` + value.id + `" class="isCheck m-3"
                                                id="">
                                            <input type="text" name="semesters[]" class="form-control semisterField" readonly
                                                value="` + value.semister_name + `">
                                            <button type="button"
                                                class="badge bg-success m-3 editSemesterBtn">Edit</button>
                                            
                                            <button type="button" class="badge bg-primary m-3 cancelEditSemesterBtn"
                                                style="display:none" value="` + value.id + `">Save</button>
                                        </div><br>`;

                        });
                        $('#appendAfterInsert').html(newOutput);
                        $('#selectedDeleteBtn').hide();
                        $('#checkedCount').html("");
                        console.log(response.newSemesterData);
                    }
                });
            }
        });
    </script>
@endpush
