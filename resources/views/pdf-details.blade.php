@extends('layout.common')
@section('main-content')
    @if ($data)
        <section class="bg-light py-0 py-sm-5">
            <div class="container">
                <div class="row py-5">
                    <div class="col-lg-8">
                        <!-- Badge -->
                        <button onclick="history.back()"
                            class="mb-3 font-base bg-primary text-white py-2 px-4 rounded-2 d-inline-block border-0">Go back
                        </button>
                        <!-- Title -->
                        <h1>{{ $data->title }}</h1>
                        <!-- Content -->
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i
                                    class="fas fa-signal text-success me-2"></i>{{ $data->getMaterial->getUniversity->name . ' ' . $data->getMaterial->getSemester->semister_name }}
                            </li>
                            <li class="list-inline-item h6 me-3 mb-1 mb-sm-0"><i
                                    class="bi bi-patch-exclamation-fill text-danger me-2"></i>Last updated
                                {{ $data->updated_at->format('d M Y h:i A') }}</li>
                            <li class="list-inline-item h6 mb-0"><i class="fas fa-globe text-info me-2"></i>Uploaded By
                                {{ $data->getAuthor->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="pb-0 py-lg-5">
            <div class="container">
                <div class="row">
                    <!-- Main content START -->
                    <div class="col-lg-12">
                        <div class="card shadow shadow rounded-2 p-4">
                            <div class="card-header border-bottom px-4 py-3">
                                <!-- Tabs START -->
                                <ul class="nav nav-pills nav-tabs-line pt-0" id="course-pills-tab" role="tablist">
                                    <!-- Tab item -->
                                    <li class="nav-item me-2 me-sm-4" role="presentation">
                                        <button class="nav-link mb-2 mb-md-0 active" id="course-pills-tab-1"
                                            data-bs-toggle="pill" data-bs-target="#course-pills-1" type="button"
                                            role="tab" aria-controls="course-pills-1"
                                            aria-selected="true">Overview</button>
                                    </li>
                                    <!-- Tab item -->
                                    <li class="nav-item me-2 me-sm-4" role="presentation">
                                        <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-4" data-bs-toggle="pill"
                                            data-bs-target="#course-pills-4" type="button" role="tab"
                                            aria-controls="course-pills-4" aria-selected="false">Reviews</button>
                                    </li>
                                </ul>
                            </div>
                            <!-- Tabs END -->

                            <div class="card-body p-4">
                                <!-- Tab contents START -->
                                <div class="tab-content pt-2" id="course-pills-tabContent">
                                    <!-- Content START -->
                                    <div class="tab-pane fade show active" id="course-pills-1" role="tabpanel"
                                        aria-labelledby="course-pills-tab-1">
                                        <!-- Course detail START -->
                                        <a href="{{ asset('storage/' . $data->pdf) }}">
                                            <button class="btn btn-success">Download</button>
                                        </a>
                                        <!-- Course detail END -->
                                        <!-- Content END -->
                                    </div>

                                    <!-- Content END -->

                                    <!-- Content START -->
                                    <div class="tab-pane fade" id="course-pills-4" role="tabpanel"
                                        aria-labelledby="course-pills-tab-4">
                                        <!-- Review START -->
                                        <div class="row mb-4">
                                            <h5 class="mb-4">Our Student Reviews</h5>

                                            <!-- Rating info -->
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <div class="text-center">
                                                    <!-- Info -->
                                                    <h2 class="mb-0">4.5</h2>
                                                    <!-- Star -->
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item me-0"><i
                                                                class="fas fa-star text-warning"></i>
                                                        </li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="fas fa-star text-warning"></i>
                                                        </li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="fas fa-star text-warning"></i>
                                                        </li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="fas fa-star text-warning"></i>
                                                        </li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="fas fa-star-half-alt text-warning"></i></li>
                                                    </ul>
                                                    <p class="mb-0">(Based on todays review)</p>
                                                </div>
                                            </div>

                                            <!-- Progress-bar and star -->
                                            <div class="col-md-8">
                                                <div class="row align-items-center">
                                                    <!-- Progress bar and Rating -->
                                                    <div class="col-6 col-sm-8">
                                                        <!-- Progress item -->
                                                        <div class="progress progress-sm bg-warning bg-opacity-15">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-4">
                                                        <!-- Star item -->
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                        </ul>
                                                    </div>

                                                    <!-- Progress bar and Rating -->
                                                    <div class="col-6 col-sm-8">
                                                        <!-- Progress item -->
                                                        <div class="progress progress-sm bg-warning bg-opacity-15">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: 80%" aria-valuenow="80" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-sm-4">
                                                        <!-- Star item -->
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                        </ul>
                                                    </div>

                                                    <!-- Progress bar and Rating -->
                                                    <div class="col-6 col-sm-8">
                                                        <!-- Progress item -->
                                                        <div class="progress progress-sm bg-warning bg-opacity-15">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: 60%" aria-valuenow="60" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-sm-4">
                                                        <!-- Star item -->
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                        </ul>
                                                    </div>

                                                    <!-- Progress bar and Rating -->
                                                    <div class="col-6 col-sm-8">
                                                        <!-- Progress item -->
                                                        <div class="progress progress-sm bg-warning bg-opacity-15">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: 40%" aria-valuenow="40" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-sm-4">
                                                        <!-- Star item -->
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                        </ul>
                                                    </div>

                                                    <!-- Progress bar and Rating -->
                                                    <div class="col-6 col-sm-8">
                                                        <!-- Progress item -->
                                                        <div class="progress progress-sm bg-warning bg-opacity-15">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-sm-4">
                                                        <!-- Star item -->
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0 small"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Review END -->

                                        <!-- Student review START -->
                                        <div class="row">
                                            <!-- Review item START -->
                                            <div class="d-md-flex my-4">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-xl me-4 flex-shrink-0">
                                                    <img class="avatar-img rounded-circle"
                                                        src="assets/images/avatar/09.jpg" alt="avatar">
                                                </div>
                                                <!-- Text -->
                                                <div>
                                                    <div class="d-sm-flex mt-1 mt-md-0 align-items-center">
                                                        <h5 class="me-3 mb-0">Jacqueline Miller</h5>
                                                        <!-- Review star -->
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item me-0"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                        </ul>
                                                    </div>
                                                    <!-- Info -->
                                                    <p class="small mb-2">2 days ago</p>
                                                    <p class="mb-2">Perceived end knowledge certainly day sweetness why
                                                        cordially. Ask a quick six seven offer see among. Handsome met
                                                        debating
                                                        sir
                                                        dwelling age material. As style lived he worse dried. Offered
                                                        related so
                                                        visitors we private removed. Moderate do subjects to distance. </p>
                                                    <!-- Like and dislike button -->
                                                    <div class="btn-group" role="group"
                                                        aria-label="Basic radio toggle button group">
                                                        <!-- Like button -->
                                                        <input type="radio" class="btn-check" name="btnradio"
                                                            id="btnradio1">
                                                        <label class="btn btn-outline-light btn-sm mb-0"
                                                            for="btnradio1"><i
                                                                class="far fa-thumbs-up me-1"></i>25</label>
                                                        <!-- Dislike button -->
                                                        <input type="radio" class="btn-check" name="btnradio"
                                                            id="btnradio2">
                                                        <label class="btn btn-outline-light btn-sm mb-0" for="btnradio2">
                                                            <i class="far fa-thumbs-down me-1"></i>2</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Comment children level 1 -->
                                            <div class="d-md-flex mb-4 ps-4 ps-md-5">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-lg me-4 flex-shrink-0">
                                                    <img class="avatar-img rounded-circle"
                                                        src="assets/images/avatar/02.jpg" alt="avatar">
                                                </div>
                                                <!-- Text -->
                                                <div>
                                                    <div class="d-sm-flex mt-1 mt-md-0 align-items-center">
                                                        <h5 class="me-3 mb-0">Louis Ferguson</h5>
                                                    </div>
                                                    <!-- Info -->
                                                    <p class="small mb-2">1 days ago</p>
                                                    <p class="mb-2">Water timed folly right aware if oh truth. Imprudence
                                                        attachment him for sympathize. Large above be to means. Dashwood
                                                        does
                                                        provide stronger is. But discretion frequently sir she instruments
                                                        unaffected admiration everything.</p>
                                                </div>
                                            </div>

                                            <!-- Divider -->
                                            <hr>
                                            <!-- Review item END -->

                                            <!-- Review item START -->
                                            <div class="d-md-flex my-4">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-xl me-4 flex-shrink-0">
                                                    <img class="avatar-img rounded-circle"
                                                        src="assets/images/avatar/07.jpg" alt="avatar">
                                                </div>
                                                <!-- Text -->
                                                <div>
                                                    <div class="d-sm-flex mt-1 mt-md-0 align-items-center">
                                                        <h5 class="me-3 mb-0">Dennis Barrett</h5>
                                                        <!-- Review star -->
                                                        <ul class="list-inline mb-0">
                                                            <li class="list-inline-item me-0"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0"><i
                                                                    class="fas fa-star text-warning"></i></li>
                                                            <li class="list-inline-item me-0"><i
                                                                    class="far fa-star text-warning"></i></li>
                                                        </ul>
                                                    </div>
                                                    <!-- Info -->
                                                    <p class="small mb-2">2 days ago</p>
                                                    <p class="mb-2">Handsome met debating sir dwelling age material. As
                                                        style
                                                        lived he worse dried. Offered related so visitors we private
                                                        removed.
                                                        Moderate do subjects to distance. </p>
                                                    <!-- Like and dislike button -->
                                                    <div class="btn-group" role="group"
                                                        aria-label="Basic radio toggle button group">
                                                        <!-- Like button -->
                                                        <input type="radio" class="btn-check" name="btnradio"
                                                            id="btnradio3">
                                                        <label class="btn btn-outline-light btn-sm mb-0"
                                                            for="btnradio3"><i
                                                                class="far fa-thumbs-up me-1"></i>25</label>
                                                        <!-- Dislike button -->
                                                        <input type="radio" class="btn-check" name="btnradio"
                                                            id="btnradio4">
                                                        <label class="btn btn-outline-light btn-sm mb-0" for="btnradio4">
                                                            <i class="far fa-thumbs-down me-1"></i>2</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Review item END -->
                                            <!-- Divider -->
                                            <hr>
                                        </div>
                                        <!-- Student review END -->

                                        <!-- Leave Review START -->
                                        <div class="mt-2">
                                            <h5 class="mb-4">Leave a Review</h5>
                                            <form class="row g-3">
                                                <!-- Name -->
                                                <div class="col-md-6 bg-light-input">
                                                    <input type="text" class="form-control" id="inputtext"
                                                        placeholder="Name" aria-label="First name">
                                                </div>
                                                <!-- Email -->
                                                <div class="col-md-6 bg-light-input">
                                                    <input type="email" class="form-control" placeholder="Email"
                                                        id="inputEmail4">
                                                </div>
                                                <!-- Rating -->
                                                <div class="col-12 bg-light-input">
                                                    <select id="inputState2" class="form-select js-choice">
                                                        <option selected="">★★★★★ (5/5)</option>
                                                        <option>★★★★☆ (4/5)</option>
                                                        <option>★★★☆☆ (3/5)</option>
                                                        <option>★★☆☆☆ (2/5)</option>
                                                        <option>★☆☆☆☆ (1/5)</option>
                                                    </select>
                                                </div>
                                                <!-- Message -->
                                                <div class="col-12 bg-light-input">
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Your review" rows="3"></textarea>
                                                </div>
                                                <!-- Button -->
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mb-0">Post
                                                        Review</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Leave Review END -->

                                    </div>
                                    <!-- Content END -->
                                </div>
                                <!-- Tab contents END -->
                            </div>
                        </div>
                    </div>
                    <!-- Main content END -->
                </div><!-- Row END -->
            </div>
        </section>
    @endif
@endsection
