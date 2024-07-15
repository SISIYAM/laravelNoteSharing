@extends('admin.layouts.common')
@section('page-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Elements</div>
                </div>
                <div class="card-body">
                    <div class="row shadow-lg p-3 mb-5 bg-ligth rounded m-1">
                        <div class="col-md-6 col-lg-8">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">University Name</label>
                                <select class="form-select" id="exampleFormControlSelect1">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Semester</label>
                                <select class="form-select" id="exampleFormControlSelect1">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group has-error has-feedback">
                                <label for="successInput">Success Input</label>
                                <input type="text" id="successInput" value="Success" class="form-control" />
                                <small id="emailHelp" class="form-text text-danger">Please provide a valid
                                    informations.</small>
                            </div>
                            <div class="form-group has-error ">
                                <label for="errorInput">Error Input</label>
                                <input type="text" id="errorInput" value="Error" class="form-control" />
                                <small id="emailHelp" class="form-text text-muted">Please provide a valid
                                    informations.</small>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Example select</label>
                                <select class="form-select" id="exampleFormControlSelect1">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Example file input</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-action">
                    <button class="btn btn-success">Submit</button>
                    <button class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
