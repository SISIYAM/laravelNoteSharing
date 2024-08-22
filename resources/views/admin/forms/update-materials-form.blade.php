@extends('admin.layouts.common-form')
@section('form-title')
    <!-- assign modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign pdfs</h5>
                    <button type="button" id="" class="close hideAssignModal" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="">

                        <input type="hidden" name="material_id_assign" id="material_id_assign">
                        <div class="form-group">
                            <label for="email">Assigned pdfs</label>
                            <div class="shadow-lg p-3 bg-body rounded"
                                style="display: flex; flex-direction:column; max-height:20vh; overflow-y:auto"
                                id="existPdfsOutput">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Assign New pdfs</label>
                            <div class="field shadow-lg p-3 mb-5 bg-body rounded" style="max-height:30vh; overflow-y:auto">
                                <div style="display:flex;flex-direction:column;padding:5px;font-size: 15px"
                                    id="notAllocatedPdfsOutput">

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
    <!-- End assign pdf modal -->

    <!-- Modal -->
    <div class="modal fade" id="addFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Material</h5>
                    <button type="button" id="" class="close hideAddFormModal" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updatePdfForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="pdf_id" id="pdf_id">
                        <input type="hidden" name="material_id" id="material_id">
                        <div class="form-group">
                            <label for="email">Current Title</label>
                            <b class="badge bg-success" id="currentTitle"></b>
                        </div>
                        <div class="form-group">
                            <label for="email">Current pdf</label>
                            <b class="badge bg-danger" id="currentPdf"></b>
                        </div>
                        <div
                            class="form-group @error('title')
                        has-error
                        @enderror  has-feedback">
                            <label for="exampleFormControlFile1">Title</label><br>
                            <input type="text" name="title" class="form-control" id="pdfTitle" />
                            @error('title')
                                <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Select File Type</label>
                            <select name="" class="form-select" id="modelFileType">
                                <option value="pdf">Pdf file</option>
                                <option value="drive">Google drive</option>
                            </select>
                        </div>

                        <div id="modelPdf"
                            class="form-group @error('pdf')
                            has-error
                            @enderror  has-feedback">
                            <label for="exampleFormControlFile1">File</label><br>
                            <input type="file" name="pdf" class="form-control-file" id="exampleFormControlFile1" />
                            @error('pdf')
                                <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                            @enderror
                        </div>
                        <div id="modelDrive" style="display: none"
                            class="form-group @error('drive')
                            has-error
                            @enderror  has-feedback">
                            <label for="exampleFormControlFile1">Google drive</label><br>
                            <input type="text" name="drive" class="form-control"
                                placeholder="Paste google drive link" />
                            @error('drive')
                                <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                            @enderror
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger hideAddFormModal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-title">Update Materials</div>
@endsection
@section('form-content')
    @if ($data)
        <form action="{{ route('admin.update.materials', $data->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="materialID" value="{{ $data->id }}">
            <div class="card-body">
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
                        <div
                            class="form-group @error('semester_id')
                        has-error
                    @enderror">
                            <label for="exampleFormControlSelect1">Semester</label>
                            <select class="form-select" name="semester_id" id="semester">
                                <option value="{{ $data->semester_id }}" selected>
                                    @isset($data->getSemester->semister_name)
                                        {{ $data->getSemester->semister_name }}
                                    @else
                                        Not allocated
                                    @endisset
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
                        <div class="form-group">
                            <label for="">Status</label>
                            <div class="form-check form-switch">
                                <input style="transform: scale(2);" class="form-check-input" type="checkbox"
                                    role="switch" id="statusSwitch" {{ $data->status == 1 ? 'checked' : '' }}>
                            </div>
                            <input type="hidden" name="status" id="status"
                                value="{{ $data->status == 1 ? '1' : '0' }}">

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
                        <hr>
                        <h3>Added Pdfs</h3>
                        <div id="addedPdf" class="">
                            @if (count($data->getPdf))
                                @foreach ($data->getPdf as $i => $pdf)
                                    <div class="form-group ">
                                        <label for="successInput">{{ $pdf->title }} - </label>
                                        <b class="badge bg-danger">{{ $pdf->pdf }}</b>
                                        @if ($pdf->type == 1)
                                            <a href="{{ asset('storage/' . $pdf->pdf) }}" target="_blank"><button
                                                    class="badge bg-dark" type="button">view</button></a>
                                        @else
                                            <a href="{{ $pdf->pdf }}" target="_blank"><button class="badge bg-dark"
                                                    type="button">view</button></a>
                                        @endif
                                        <button type="button" class="badge bg-primary border-0 showUpdatePdfModal"
                                            value="{{ $pdf->id }}">Change</button>
                                        <button type="button" class="badge bg-danger border-0 deletPdfBtn"
                                            value="{{ $pdf->id }}">Delete</button>
                                    </div>
                                @endforeach
                            @else
                                <p class="alert alert-danger bg-danger text-light d-inline">No pdfs added yet!</p>
                            @endif
                        </div>
                        <hr>
                        <h3>Assing from existing not allocated pdfs</h3>
                        <div class="form-group">
                            <button id="assignPdfBtn" style="transform: scale(1.2)" type="button"
                                class="badge bg-danger" value="{{ $data->id }}">Assign</button>
                        </div>
                        <hr>
                        <h3>Add new pdfs</h3>
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
    @endif
@endsection

@push('ajax')
    <script>
        //show assign modal
        $(document).on("click", "#assignPdfBtn", function(e) {
            e.preventDefault();
            const material_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('admin.assign.pdf') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    material_id: material_id,
                },
                success: function(response) {
                    console.log(response.notAllocatedPdfs);
                    let data = "";
                    let existData = "";
                    if (response.success) {
                        response.notAllocatedPdfs.forEach(element => {
                            data += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isPdfCheck" type="checkbox" value=${element.id} role="switch"
                                                id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">${element.title}</label>
                                            
                                        </div>
                                    </div>`;
                        });
                        response.existPdfs.forEach(element => {
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
                                <button class="badge bg-danger removeAssignedPdf" value="${element.id}">Remove</button>
                                </div>`
                        });

                    }
                    if (existData == "") {
                        existData = `<p class="text-danger">No result found</p>`;

                    }
                    if (data == "") {
                        data = `<p class="text-danger">No result found</p>`;
                    }

                    $("#existPdfsOutput").html(existData);
                    $("#notAllocatedPdfsOutput").html(data);
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr);
                },
            });
            $("#material_id_assign").val(material_id);
            $("#assignModal").modal("show");
        });

        // enable assign material form submit btn
        $(document).on("click", ".isPdfCheck", function(e) {
            const pdfs = [];
            $(".isPdfCheck:checked").each(function() {
                pdfs.push($(this).val());
            });

            if (!jQuery.isEmptyObject(pdfs)) {
                $("#submitAssignForm").removeAttr('disabled');
            } else {
                $("#submitAssignForm").attr('disabled',
                    'disabled');
            }
        });

        // submit assigned materials form
        $(document).on("click", "#submitAssignForm", function(e) {
            e.preventDefault();
            const materialId = $("#material_id_assign").val();

            // Collect all  assigned materials id into an array
            const pdfs = [];
            $(".isPdfCheck:checked").each(function() {
                pdfs.push($(this).val());
            });
            $.ajax({
                type: "POST",
                url: "{{ route('admin.ajax.assign.pdf') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    material_id: materialId,
                    checkedPdfs: pdfs,
                },
                success: function(response) {
                    let newData = "";
                    let notAllocatedData = "";
                    console.log(response.existPdfs);
                    response.existPdfs.forEach(element => {
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
                                <span>${element.title} </span>
                                <button class="badge bg-danger removeAssignedPdf" value="${element.id}">Remove</button>
                                </div>`;
                    });

                    response.notAllocatedPdfs.forEach(element => {
                        notAllocatedData += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isPdfCheck" type="checkbox" value=${element.id} role="switch"
                                                id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">${element.title} </label>
                                        </div>


                                    </div>`;
                    });

                    if (newData == "") {
                        newData = `<p class="text-danger">No result found</p>`
                    }

                    if (notAllocatedData == "") {
                        notAllocatedData = `<p class="text-danger">No result found</p>`
                    }

                    $("#existPdfsOutput").html(newData);
                    $("#notAllocatedPdfsOutput").html(notAllocatedData);

                    // handel adde pdfs div
                    let newAddedDivData = "";
                    let view = "";
                    let url = "{{ asset('storage') }}/";
                    $.each(response.existPdfs, function(index, value) {
                        if (value.type == 1) {
                            view = `<a href="${url}${value.pdf}" target="_blank"><button
                            class="badge bg-dark" type="button">view</button></a>`;
                        } else {
                            view = `<a href="${value.pdf}" target="_blank"><button
                            class="badge bg-dark" type="button">view</button></a>`;
                        }
                        newAddedDivData += ` <div class="form-group ">
                           <label for="successInput">${value.title} - </label>
                           <b class="badge bg-danger">${value.pdf}</b>
                           ${view}
                           <button type="button" class="badge bg-primary border-0 showUpdatePdfModal"
                               value="${value.id}">Change</button>
                           <button type="button" class="badge bg-danger border-0 deletPdfBtn"
                               value="${value.id}">Delete</button>
                            </div>`;

                    });

                    if (newAddedDivData == "") {
                        newAddedDivData = `<p class="alert alert-danger">No pdf added yet!</p>`;
                    }
                    $('#addedPdf').html(newAddedDivData);

                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr)
                }
            });
        });

        // removed assigned pdfs
        $(document).on("click", ".removeAssignedPdf", function(e) {
            e.preventDefault();
            const id = $(this).val();
            const material_id = $("#material_id_assign").val();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.ajax.not.assigned.pdf') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    pdf_id: id,
                    material_id: material_id,
                },
                success: function(response) {
                    let newData = "";
                    let notAllocatedData = "";
                    console.log(response);
                    response.pdfs.forEach(element => {
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
                                <button class="badge bg-danger removeAssignedPdf" value="${element.id}">Remove</button>
                                </div>`;
                    });

                    response.notAllocated.forEach(element => {
                        notAllocatedData += `<div style="display:flex;align-items:center;">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input isPdfCheck" type="checkbox" value=${element.id} role="switch"
                                                id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">${element.title} </label>
                                        </div>


                                    </div>`;
                    });

                    if (newData == "") {
                        newData = `<p class="text-danger">No result found</p>`
                    }

                    if (notAllocatedData == "") {
                        notAllocatedData = `<p class="text-danger">No result found</p>`
                    }

                    $("#existPdfsOutput").html(newData);
                    $("#notAllocatedPdfsOutput").html(notAllocatedData);

                    // handel adde pdfs div
                    let newAddedDivData = "";
                    let view = "";
                    let url = "{{ asset('storage') }}/";
                    $.each(response.pdfs, function(index, value) {
                        if (value.type == 1) {
                            view = `<a href="${url}${value.pdf}" target="_blank"><button
                            class="badge bg-dark" type="button">view</button></a>`;
                        } else {
                            view = `<a href="${value.pdf}" target="_blank"><button
                            class="badge bg-dark" type="button">view</button></a>`;
                        }
                        newAddedDivData += ` <div class="form-group ">
                           <label for="successInput">${value.title} - </label>
                           <b class="badge bg-danger">${value.pdf}</b>
                           ${view}
                           <button type="button" class="badge bg-primary border-0 showUpdatePdfModal"
                               value="${value.id}">Change</button>
                           <button type="button" class="badge bg-danger border-0 deletPdfBtn"
                               value="${value.id}">Delete</button>
                            </div>`;

                    });

                    if (newAddedDivData == "") {
                        newAddedDivData = `<p class="alert alert-danger">No pdf added yet!</p>`;
                    }
                    $('#addedPdf').html(newAddedDivData);


                }
            });
        });

        // hide assign modal
        $(document).on("click", ".hideAssignModal", function(e) {
            e.preventDefault();
            $("#assignModal").modal("hide");
        })

        // handle status switch
        $(document).on("click", "#statusSwitch", function(e) {
            if ($("#statusSwitch").is(':checked')) {
                $("#status").val(1);
            } else {
                $("#status").val(0);
            }
        })

        // search semester according to university name
        $(document).on("change", "#selectUniversity", function(e) {
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
        $(document).on('click', '.showUpdatePdfModal', function(e) {
            e.preventDefault();
            const id = $(this).val();
            const materialId = $("#materialID").val();

            // fetch pdf data by using ajax
            $.ajax({
                type: "post",
                url: "{{ route('admin.ajax.pdf') }}",
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token
                    id: id,
                },

                success: function(response) {
                    $('#currentPdf').html(response.pdf);
                    $('#currentTitle').html(response.title);
                    $('#pdfTitle').val(response.title);
                    $('#pdf_id').val(response.id);
                    $('#material_id').val(materialId);
                }
            });

            $('#addFormModal').modal('show');

        });

        // Handle PDF update form submission
        $(document).on('submit', '#updatePdfForm', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ route('admin.ajax.update.pdf') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    let newData = "";
                    if (response.success) {
                        $('#currentTitle').html(response.pdf.title);
                        $('#currentPdf').html(response.pdf.pdf);
                        let view = "";
                        let url = "{{ asset('storage') }}/";
                        $.each(response.materialPdf, function(index, value) {
                            if (value.type == 1) {
                                view = `<a href="${url}${value.pdf}" target="_blank"><button
                            class="badge bg-dark" type="button">view</button></a>`;
                            } else {
                                view = `<a href="${value.pdf}" target="_blank"><button
                            class="badge bg-dark" type="button">view</button></a>`;
                            }
                            newData += ` <div class="form-group ">
                         <label for="successInput">${value.title} - </label>
                         <b class="badge bg-danger">${value.pdf}</b>
                         ${view}
                         <button type="button" class="badge bg-primary border-0 showUpdatePdfModal"
                         value="${value.id}">Change</button>
                         <button type="button" class="badge bg-danger border-0 deletPdfBtn"
                             value="${value.id}">Delete</button>
                         </div>`;

                        });

                        if (newData == "") {
                            newData = `<p class="alert alert-danger">No pdf added yet!</p>`;
                        }
                        $('#addedPdf').html(newData);
                        swal("Success!", response.success, {
                            icon: "success",
                            buttons: {
                                confirm: {
                                    className: "btn btn-success",
                                },
                            },
                        });

                    }


                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr)
                }
            });
        });

        // delete pdf
        $(document).on('click', '.deletPdfBtn', function() {
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
                        url: "{{ route('admin.delete.pdf') }}",
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
