<header class="navbar-light navbar-sticky header-static">
    <!-- Logo Nav START -->
    <nav class="navbar navbar-expand-xl">
        <div class="container">
            <!-- Logo START -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img class="light-mode-item navbar-brand-item" src="{{ asset('assets/images/logo.svg') }}" alt="logo">
            </a>
            <!-- Logo END -->

            <!-- Responsive navbar toggler -->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-animation">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <!-- Main navbar START -->
            <div class="navbar-collapse w-100 collapse" id="navbarCollapse">

                <ul class="navbar-nav navbar-nav-scroll mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="docs/alerts.html">Blogs</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('faculties') }}">Faculties</a></li>
                    <li class="nav-item"><a class="nav-link" href="docs/alerts.html">Students</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="demoMenu" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Others</a>
                        <ul class="dropdown-menu" aria-labelledby="demoMenu">
                            <li> <a class="dropdown-item" href="index.html">About us</a></li>
                            <li> <a class="dropdown-item" href="index.html">Contact us</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li> <a class="dropdown-item" href="request-demo.html">Request for materials</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        </ul>
                    </li>

                </ul>

                <div class="nav my-3 my-xl-0 px-4 flex-nowrap align-items-center">
                    <div class="nav-item w-100">
                        <form class="position-relative">
                            <input class="form-control pe-5 bg-transparent" type="search" placeholder="Search"
                                aria-label="Search">
                            <button
                                class="btn bg-transparent px-2 py-0 position-absolute top-50 end-0 translate-middle-y"
                                type="submit"><i class="fas fa-search fs-6 "></i></button>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </nav>

</header>
