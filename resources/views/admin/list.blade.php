@extends('admin.layouts.common-table')
@section('table-row')
    <!-- Modal -->
    <div class="modal fade" id="addFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add</h5>
                    <button type="button" id="" class="close hideAddFormModal" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.add.university') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div
                            class="form-group @error('name')
                        has-error
                        @enderror  has-feedback">
                            <label for="email">University Name</label>
                            <input type="text" name="name" id="errorInput" value="{{ old('name') }}"
                                class="form-control" />
                            @error('name')
                                <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                            @enderror
                        </div>
                        <div
                            class="form-group @error('image')
                        has-error
                        @enderror  has-feedback">
                            <label for="exampleFormControlFile1">University Logo</label><br>
                            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" />

                        </div>
                        @error('image')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger hideAddFormModal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <tr>
        <td>Tiger Nixon</td>
        <td>System Architect</td>
        <td>Edinburgh</td>
        <td>Edinburgh</td>
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
@endsection

@if (Session::has('success'))
    @push('script')
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
