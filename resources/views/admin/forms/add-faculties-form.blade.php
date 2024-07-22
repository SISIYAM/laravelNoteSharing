@extends('admin.layouts.common-form')
@section('form-title')
    Add faculty
@endsection
@section('form-content')
    <form action="{{ route('admin.add.faculties') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body" id="dynamicForm">
            <div class="row shadow-lg p-3 mb-5 bg-ligth rounded m-1">
                <div class="col-md-6 col-lg-10">

                    <div class="form-group @error('name')
    has-error
    @enderror  has-feedback">
                        <label for="email">Name</label>
                        <input type="text" name="name" id="errorInput" value="{{ old('name') }}" class="form-control"
                            placeholder="Enter Teacher's name (e.g- Cristiano Ronaldo)" />
                        @error('name')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group @error('resignation')
    has-error
    @enderror  has-feedback">
                        <label for="email">Resignation</label>
                        <input type="text" name="resignation" id="errorInput" value="{{ old('resignation') }}"
                            class="form-control" placeholder="Enter resignation (e.g- Asst Professor)" />
                        @error('resignation')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group @error('degree')
    has-error
    @enderror  has-feedback">
                        <label for="email">Degree</label>
                        <input type="text" name="degree" id="errorInput" value="{{ old('degree') }}"
                            class="form-control" placeholder="Enter degree (e.g- BSC in Football)" />
                        @error('degree')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group @error('email')
    has-error
    @enderror  has-feedback">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="errorInput" value="{{ old('email') }}"
                            class="form-control" placeholder="Enter email (e.g- cr7@gmail.com)" />
                        @error('email')
                            <small id="emailHelp" class="form-text text-danger text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group @error('mobile')
    has-error
    @enderror  has-feedback">
                        <label for="email">Mobile</label>
                        <input type="text" name="mobile" id="errorInput" value="{{ old('mobile') }}"
                            class="form-control" placeholder="Enter mobile (e.g- 01722456977)" />
                        @error('mobile')
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
                        <label for="exampleFormControlFile1">Image (Dimensions: 600x600 px)</label><br>
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
