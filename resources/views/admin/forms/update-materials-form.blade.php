@extends('admin.layouts.common-form')
@section('form-title')
    <div class="card-title">Update Materials</div>
@endsection
@section('form-content')
    @if ($data)
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
                                <option value="{{ $data->university_id }}" selected>{{ $data->getUniversity->name }}
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
                        <div
                            class="form-group @error('semester_id')
                        has-error
                    @enderror">
                            <label for="exampleFormControlSelect1">Semester</label>
                            <select class="form-select" name="semester_id" id="semester">
                                <option value="{{ $data->semester_id }}" selected>{{ $data->getSemester->semister_name }}
                                </option>
                                @foreach ($semesters as $semester)
                                    @php
                                        if ($semester->id == $data->semester_id) {
                                            continue;
                                        }
                                    @endphp
                                    <option value="{{ $semester->id }}">{{ $semester->semister_name }}</option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div
                            class="form-group  @error('title')
                      has-error
                    @enderror">
                            <label for="successInput">Title</label>
                            <input type="text" name="title" value="{{ $data->title }}" id="successInput"
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
                            <textarea name="description" id="editor">{{ $data->description }}</textarea>
                            @error('description')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @foreach ($data->getPdf as $i => $pdf)
                            <div class="form-group ">
                                <label for="successInput">PDF {{ $i + 1 }} - </label>
                                <b class="badge bg-danger">{{ $pdf->pdf }}</b>

                                <input style="display: none" type="file" name="pdfs[]"
                                    class="form-control-file hiddenPdfField">
                            </div>
                        @endforeach
                        <div class="form-group">
                            <button type="button" class="badge bg-primary showPdfField">Change</button>
                        </div>
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

                                    <input type="file" name="pdfs[]" class="form-control-file"
                                        id="exampleFormControlFile1" />
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
    @endif
@endsection

@push('ajax')
    <script>
        // search semester according to university name
        $("#selectUniversity").on("change", function(e) {
            e.preventDefault();

            const universityId = $(this).val();

            $.ajax({
                type: "POST",
                url: "{{ route('admin.semester.ajax') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    id: universityId,
                },

                success: function(response) {
                    $('#semester').empty();

                    if (response.length > 0) {
                        $.each(response, function(key, value) {
                            $('#semester').append('<option value="' + value.id + '">' + value
                                .semister_name +
                                '</option>');
                        });
                    } else {
                        $('#semester').append('<option value="">No semesters added yet</option>');
                    }
                },
            });
        });
    </script>
@endpush

@push('script')
    <script>
        $('.showPdfField').on('click', function() {
            $('.hiddenPdfField').toggle();
        });
    </script>
@endpush
