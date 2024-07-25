@extends('layout.common')
@section('main-content')
    <section class="py-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark p-4 text-center rounded-3">
                        <h1 class="text-white m-0">Faculties list</h1>
                        <!-- Breadcrumb -->
                        <div class="d-flex justify-content-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-dark breadcrumb-dots mb-0">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">instructor list</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-4">
        <div class="container">
            <div class="row g-4 justify-content-center">

                @foreach ($data as $row)
                    <div class="col-lg-10 col-xl-6">
                        <div class="card shadow p-2">
                            <div class="row g-0">
                                <!-- Image -->
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/' . $row->image) }}" class="rounded-3" alt="...">
                                </div>

                                <!-- Card body -->
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <!-- Title -->
                                        <div class="d-sm-flex justify-content-sm-between mb-2 mb-sm-3">
                                            <div>
                                                <h5 class="card-title mb-0"><a href="#">{{ $row->name }}</a></h5>
                                                <p class="small mb-2 mb-sm-0">{{ $row->post }}</p>
                                            </div>

                                        </div>
                                        <!-- Content -->
                                        <p class="text-truncate-2 mb-3">Perceived end knowledge certainly day sweetness why
                                            cordially. Ask a quick six seven offer see among.</p>
                                        <!-- Info -->
                                        <div class="d-sm-flex justify-content-sm-between align-items-center">
                                            <!-- Title -->
                                            <h6 class="text-orange mb-0">Digital Marketing</h6>

                                            <!-- Social button -->
                                            <ul class="list-inline mb-0 mt-3 mt-sm-0">
                                                <li class="list-inline-item">
                                                    <a class="mb-0 me-1 text-facebook" href="#"><i
                                                            class="fab fa-fw fa-facebook-f"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="mb-0 me-1 text-instagram-gradient" href="#"><i
                                                            class="fab fa-fw fa-instagram"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="mb-0 me-1 text-twitter" href="#"><i
                                                            class="fab fa-fw fa-twitter"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="mb-0 text-linkedin" href="#"><i
                                                            class="fab fa-fw fa-linkedin-in"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <nav class="mt-4 d-flex justify-content-center" aria-label="navigation">
                <ul class="pagination pagination-primary-soft rounded mb-0">
                    <li class="page-item mb-0"><a class="page-link" href="#" tabindex="-1"><i
                                class="fas fa-angle-double-left"></i></a></li>
                    <li class="page-item mb-0"><a class="page-link" href="#">1</a></li>
                    <li class="page-item mb-0 active"><a class="page-link" href="#">2</a></li>
                    <li class="page-item mb-0"><a class="page-link" href="#">..</a></li>
                    <li class="page-item mb-0"><a class="page-link" href="#">6</a></li>
                    <li class="page-item mb-0"><a class="page-link" href="#"><i
                                class="fas fa-angle-double-right"></i></a></li>
                </ul>
            </nav>
            <!-- Pagination END -->

        </div>
    </section>
    <section class="pt-0">
        <div class="container position-relative">
            <!-- SVG -->
            <figure class="position-absolute top-50 start-50 translate-middle ms-2">
                <svg>
                    <path
                        d="m496 22.999c0 10.493-8.506 18.999-18.999 18.999s-19-8.506-19-18.999 8.507-18.999 19-18.999 18.999 8.506 18.999 18.999z"
                        fill="#fff" fill-rule="evenodd" opacity=".502"></path>
                    <path
                        d="m775 102.5c0 5.799-4.701 10.5-10.5 10.5-5.798 0-10.499-4.701-10.499-10.5 0-5.798 4.701-10.499 10.499-10.499 5.799 0 10.5 4.701 10.5 10.499z"
                        fill="#fff" fill-rule="evenodd" opacity=".102"></path>
                    <path
                        d="m192 102c0 6.626-5.373 11.999-12 11.999s-11.999-5.373-11.999-11.999c0-6.628 5.372-12 11.999-12s12 5.372 12 12z"
                        fill="#fff" fill-rule="evenodd" opacity=".2"></path>
                    <path
                        d="m20.499 10.25c0 5.66-4.589 10.249-10.25 10.249-5.66 0-10.249-4.589-10.249-10.249-0-5.661 4.589-10.25 10.249-10.25 5.661-0 10.25 4.589 10.25 10.25z"
                        fill="#fff" fill-rule="evenodd" opacity=".2"></path>
                </svg>
            </figure>

            <div class="bg-success p-4 p-sm-5 rounded-3">
                <div class="row justify-content-center position-relative">
                    <!-- Svg -->
                    <figure class="fill-white opacity-1 position-absolute top-50 start-0 translate-middle-y">
                        <svg width="141px" height="141px">
                            <path
                                d="M140.520,70.258 C140.520,109.064 109.062,140.519 70.258,140.519 C31.454,140.519 -0.004,109.064 -0.004,70.258 C-0.004,31.455 31.454,-0.003 70.258,-0.003 C109.062,-0.003 140.520,31.455 140.520,70.258 Z">
                            </path>
                        </svg>
                    </figure>
                    <!-- Action box -->
                    <div class="col-11 position-relative">
                        <div class="row align-items-center">
                            <!-- Title -->
                            <div class="col-lg-7">
                                <h3 class="text-white">Become an Instructor!</h3>
                                <p class="text-white mb-3 mb-lg-0">Speedily say has suitable disposal add boy. On forth
                                    doubt miles of child. Exercise joy man children rejoiced. Yet uncommonly his ten who
                                    diminution astonished.</p>
                            </div>
                            <!-- Button -->
                            <div class="col-lg-5 text-lg-end">
                                <a href="#" class="btn btn-dark mb-0">Start Teaching today</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
