@extends('layout.common')
@section('main-content')
    @if ($data)
        <section class="pt-3 pt-xl-5">
            <div class="container" data-sticky-container="">
                <div class="row g-4">
                    <!-- Main content START -->
                    <div class="col-xl-12">

                        <div class="row g-4">
                            <!-- Title START -->
                            <div class="col-12">
                                <!-- Title -->
                                <h2>{{ $data->title }}</h2>
                                <!-- Content -->
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item fw-light h6 me-3 mb-1 mb-sm-0"><i
                                            class="fas fa-signal me-2"></i>
                                        <b
                                            class="text-primary">{{ $data->getUniversity->name . ' ' . $data->getSemester->semister_name }}</b>
                                    </li>
                                    <li class="list-inline-item fw-light h6 me-3 mb-1 mb-sm-0"><i
                                            class="bi bi-patch-exclamation-fill me-2"></i>
                                        Last updated: {{ $data->updated_at->format('d M Y h:i A') }}</li>
                                    <li class="list-inline-item fw-light h6"><i class="fas fa-globe me-2"></i>Uploaded By-
                                        {{ $data->author }}</li>
                                </ul>
                            </div>
                            <!-- Title END -->

                            <!-- Image and video -->
                            <div class="col-12 position-relative">

                            </div>

                            <!-- About course START -->
                            <div class="col-12">
                                <div class="card border">
                                    <!-- Card header START -->
                                    <div class="card-header border-bottom">
                                        <h3 class="mb-0">Description</h3>
                                    </div>
                                    <!-- Card header END -->

                                    <!-- Card body START -->
                                    <div class="card-body">
                                        @if ($data->description)
                                            {{ $data->description }}
                                        @else
                                            <p class="alert alert-danger">No description added yet!</p>
                                        @endif
                                    </div>
                                    <!-- Card body START -->
                                </div>
                            </div>
                            <!-- About course END -->

                            <!-- Curriculum START -->
                            <div class="col-12">
                                <div class="card border rounded-3">
                                    <!-- Card header START -->
                                    <div class="card-header border-bottom">
                                        <h3 class="mb-0">PDFS</h3>
                                    </div>
                                    <!-- Card header END -->

                                    <!-- Card body START -->
                                    <div class="card-body">
                                        <div class="row g-5">
                                            <!-- Lecture item START -->
                                            <div class="col-12">
                                                @foreach (json_decode($data->pdf) as $pdfIndex => $pdf)
                                                    <div class="d-sm-flex justify-content-sm-between align-items-center">
                                                        <div class="d-flex">
                                                            <a href="#" class="btn btn-danger-soft btn-round mb-0"><i
                                                                    class="fas fa-play"></i></a>
                                                            <div class="ms-2 ms-sm-3 mt-3">
                                                                <h6 class="mb-0">Pdf- {{ $pdfIndex + 1 }}</h6>
                                                                <p></p>
                                                            </div>
                                                        </div>
                                                        <!-- Button -->
                                                        <a href="{{ asset('storage/' . $pdf) }}"
                                                            class="btn btn-sm btn-success mb-0">Download</a>
                                                    </div>
                                                    <hr>
                                                @endforeach

                                            </div>
                                            <!-- Lecture item END -->

                                        </div>
                                    </div>
                                    <!-- Card body START -->
                                </div>
                            </div>
                            <!-- Curriculum END -->
                        </div>
                    </div>
                    <!-- Main content END -->


                </div><!-- Row END -->
            </div>
        </section>
    @else
        <p class="alert alert-danger">No result Found</p>
    @endif
@endsection