@extends('admin.layouts.common-form')
@section('form-title')
    Add University
@endsection
@section('form-content')
    <form action="{{ route('admin.add.university') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body" id="dynamicForm">
            <div class="row shadow-lg p-3 mb-5 bg-ligth rounded m-1">
                <div class="col-md-6 col-lg-10">

                    <div class="form-group @error('name')
        has-error
        @enderror  has-feedback">
                        <label for="email">University Name</label>
                        <input type="text" name="name" id="errorInput" value="{{ old('name') }}" class="form-control"
                            placeholder="Enter university name (e.g- BSMRAAU)" />
                        @error('name')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group @error('semester')
        has-error
        @enderror  has-feedback">
                        <label for="email">Total Semesters</label>
                        <input type="text" name="semester" id="errorInput" value="{{ old('semester') }}"
                            class="form-control" placeholder="Enter semesters number (e.g- 8)" />
                        @error('semester')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group  @error('description')
                  has-error
                @enderror">
                        <label for="successInput">Description</label>
                        <textarea name="description" id="editor">{{ old('description') }}</textarea>
                        @error('description')
                            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group @error('image')
        has-error
        @enderror  has-feedback">
                        <label for="exampleFormControlFile1">University Logo</label><br>
                        <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" />

                    </div>
                    @error('image')
                        <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                    @enderror
                </div>
            </div>


        </div>
        <div class="card-action">
            <button type="submit" class="btn btn-success">Submit</button>
            <button class="btn btn-danger">Cancel</button>
        </div>
    </form>
@endsection
