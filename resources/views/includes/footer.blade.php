<footer class="bg-dark pt-5">
    <div class="container">
        <!-- Row START -->
        <div class="row g-4">

            <!-- Widget 1 START -->
            <div class="col-lg-3">
                <!-- logo -->
                <a class="me-0" href="{{ route('home') }}">
                    <b class="text-light h3">SEI Innovations</b>
                </a>
                <p class="my-3 text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta totam debitis
                    asperiores voluptates earum facere cumque maiores iste placeat! </p>
                <!-- Social media icon -->
                <ul class="list-inline mb-0 mt-3">
                    <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-facebook"
                            href="#"><i class="fab fa-fw fa-facebook-f"></i></a> </li>
                    <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-instagram"
                            href="#"><i class="fab fa-fw fa-instagram"></i></a> </li>
                    <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-twitter"
                            href="#"><i class="fab fa-fw fa-twitter"></i></a> </li>
                    <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-linkedin"
                            href="#"><i class="fab fa-fw fa-linkedin-in"></i></a> </li>
                </ul>
            </div>
            <!-- Widget 1 END -->

            <!-- Widget 2 START -->
            <div class="col-lg-6">
                <div class="row g-4">
                    <!-- Link block -->
                    <div class="col-6 col-md-4">
                        <h5 class="mb-2 mb-md-4 text-white">Company</h5>
                        <ul class="nav flex-column text-primary-hover">
                            <li class="nav-item"><a class="nav-link" href="#">About us</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Contact us</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">News and Blogs</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Library</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Career</a></li>
                        </ul>
                    </div>

                    <!-- Link block -->
                    <div class="col-6 col-md-4">
                        <h5 class="mb-2 mb-md-4 text-white">Community</h5>
                        <ul class="nav flex-column text-primary-hover">
                            <li class="nav-item"><a class="nav-link" href="#">Documentation</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Faq</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Forum</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Sitemap</a></li>
                        </ul>
                    </div>

                    <!-- Link block -->
                    <div class="col-6 col-md-4">
                        <h5 class="mb-2 mb-md-4 text-white">Teaching</h5>
                        <ul class="nav flex-column text-primary-hover">
                            <li class="nav-item"><a class="nav-link" href="#">Become a teacher</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">How to guide</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Terms &amp; Conditions</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Widget 2 END -->

            <!-- Widget 3 START -->
            <div class="col-lg-3">
                <h5 class="mb-2 mb-md-4 text-white">Contact</h5>
                <!-- Time -->
                <p class="mb-2 text-muted">
                    Toll free:<span class="h6 fw-light text-white ms-2">+1234 568 963</span>
                    <span class="d-block small">(9:AM to 8:PM IST)</span>
                </p>

                <p class="mb-0 text-muted">Email:<span class="h6 fw-light text-white ms-2">si31siyam@gmail.com</span>
                </p>
                <!-- Row END -->
            </div>
            <!-- Widget 3 END -->
        </div><!-- Row END -->

        <!-- Divider -->
        <hr class="mt-4 mb-0">

        <!-- Bottom footer -->
        <div class="py-3">
            <div class="container px-0">
                <div class="d-md-flex justify-content-between align-items-center py-3 text-center text-md-left">
                    <!-- copyright text -->
                    <div class="text-muted text-primary-hover">
                        <b><a href="https://siyam70.netlify.app/">Developed By- MD Saymum Islam Siyam</a></b><br>
                        Copyrights <a href="#" class="text-reset">©2024
                            SEI Innovations</a>
                    </div>
                    <!-- copyright links-->
                    <div class=" mt-3 mt-md-0">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item text-primary-hover"><a class="nav-link" href="#">Terms
                                    of use</a></li>
                            <li class="list-inline-item text-primary-hover"><a class="nav-link pe-0"
                                    href="#">Privacy policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- Back to top -->
<div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i>
</div>

<!-- Bootstrap JS -->
<script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<!-- pdf js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"
    integrity="sha512-Z8CqofpIcnJN80feS2uccz+pXWgZzeKxDsDNMD/dJ6997/LSRY+W4NmEt9acwR+Gt9OHN0kkI1CTianCwoqcjQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Vendors -->
<script src="{{ asset('assets/vendor/tiny-slider/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.js') }}"></script>
<script src="{{ asset('assets/vendor/purecounterjs/dist/purecounter_vanilla.js') }}"></script>

<!-- Template Functions -->
<script src="{{ asset('assets/js/functions.js') }}"></script>

@stack('script')


</body>

</html>
