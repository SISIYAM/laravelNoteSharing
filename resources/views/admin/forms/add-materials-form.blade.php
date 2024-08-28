@extends('admin.layouts.common-form')
@section('form-title')
    <div class="card-title">Add Materials</div>
@endsection
@section('form-content')
    <form action="{{ route('admin.add.materials') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row shadow-lg p-3 mb-5 bg-ligth rounded m-1">
                <div class="col-md-6 col-lg-10">
                    <div
                        class="form-group @error('university_id')
                    has-error
                    @enderror">
                        <label for="exampleFormControlSelect1">University Name</label>
                        <select class="form-select" name="university_id" id="selectUniversity">
                            <option value="">Select Universities</option>
                            @if (count($universities) > 0)
                                @foreach ($universities as $university)
                                    <option value="{{ $university->id }}">{{ $university->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('university_id')
                            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div
                        class="form-group @error('department_id')
                        has-error
                    @enderror">
                        <label for="exampleFormControlSelect1">Department</label>
                        <select class="form-select" name="department_id" id="departmentField">
                            <option value="">Select a Department first</option>
                        </select>
                        @error('department_id')
                            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div
                        class="form-group @error('semester_id')
                        has-error
                    @enderror">
                        <label for="exampleFormControlSelect1">Semester</label>
                        <select class="form-select" name="semester_id" id="semesterField">
                            <option value="">Select a university first</option>
                        </select>
                        @error('semester_id')
                            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group  @error('title')
                      has-error
                    @enderror">
                        <label for="successInput">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" id="successInput"
                            placeholder="Enter Title" class="form-control" />
                        @error('title')
                            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div
                        class="form-group  @error('description')
                      has-error
                    @enderror">
                        <label for="successInput">Description</label>
                        <textarea name="description" id="editor">{{ old('description') }}</textarea>
                        @error('description')
                            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Select File type</label>
                        <select name="" class="form-select" id="fileType">
                            <option value="drive">Drive Link</option>
                            <option value="pdf" selected>PDF File</option>
                        </select>
                    </div>
                    <div style="" id="pdfFile">
                        <div class="form-group" style="margin-bottom: -20px">
                            <label for="" class="text-dark">Pdfs</label>
                            <span class="addInputPdf badge bg-success mx-2" style="cursor: pointer">Add more</span>
                        </div>
                        <hr>
                        @error('pdfs')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                        @error('pdfs.*')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                        <div class="dynamicPdf">
                            <div class="d-flex">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter title" name="titlesPdf[]"
                                        class="form-control my-2">
                                    <input type="file" name="pdfs[]" class="form-control-file"
                                        id="exampleFormControlFile1" />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Drive link --}}
                    <div style="display: none" id="driveFile">
                        <div class="form-group" style="margin-bottom: -20px">
                            <label for="" class="text-dark">Google Drive </label>
                            <span class="addInputDrive badge bg-success mx-2" style="cursor: pointer">Add more</span>
                        </div>
                        <hr>
                        @error('links')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                        @error('links.*')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                        <div class="dynamicDrive">
                            <div class="">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter title" name="titlesDrive[]"
                                        class="form-control my-2">
                                    <input type="text" name="links[]" class="form-control"
                                        placeholder="Paste Google Drive link" id="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-action">
            <button type="submit" class="btn btn-success">Submit</button>
            <button class="btn btn-danger">Cancel</button>
        </div>
    </form>
@endsection

@push('ajax')
    <script>
        // search department according to university name
        $("#selectUniversity").on("change", function(e) {
            e.preventDefault();

            const universityId = $(this).val();

            $.ajax({
                type: "POST",
                url: "{{ route('admin.department.ajax') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    id: universityId,
                },

                success: function(response) {
                    $('#departmentField').empty();
                    $('#semesterField').empty();

                    if (response.departments.length > 0) {
                        $.each(response.departments, function(key, value) {
                            $('#departmentField').append(
                                `<option value="${value.id}">${value.department}</option>`);

                        });
                    } else {
                        $('#departmentField').append(
                            '<option value="">No departments added yet</option>');
                    }



                    if (response.availableSemesters.length > 0) {
                        $.each(response.availableSemesters, function(key, value) {
                            $('#semesterField').append(
                                `<option value="${value.id}">${value.semister_name}</option>`
                            );
                        });
                    } else {
                        $('#semesterField').append(
                            '<option value="">No semesters available</option>'
                        );
                    }

                },
            });
        });

        // search semesters according to department name
        $("#departmentField").on("change", function(e) {
            e.preventDefault();

            const departmentID = $(this).val();

            $.ajax({
                type: "POST",
                url: "{{ route('admin.semester.ajax') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    id: departmentID,
                },

                success: function(response) {
                    $('#semesterField').empty();

                    if (response.length > 0) {
                        $.each(response, function(key, value) {
                            $('#semesterField').append(
                                `<option value="${value.id}">${value.semister_name}</option>`
                            );

                        });
                    } else {
                        $('#semesterField').append(
                            '<option value="">No semesters added yet</option>');
                    }

                },
            });
        });
    </script>
@endpush
