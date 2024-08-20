<!DOCTYPE html>
<html>

<head>
    <title>Data Hub</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

    <!-- <link rel="stylesheet" href="{{ asset('style.css') }}"> -->

    <link rel="stylesheet" href="{{ asset('dashboard.css') }}">

    <!-- SWEETALERT -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- FONT AWSOME  -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('scripts')


</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bxl-postgresql fs-1'></i>
            <!-- <span class="mx-3"><img src="" alt="Logo" width="35" style="border-radius: 50%;" class="bg-light "></span> -->
            <span class="logo_name ms-3">datahub</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class='bx bx-grid-alt'></i>
                    <span class="link_name">Add Products</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a href="{{ route('dashboard') }}" class="link_name">Add Products</a></li>
                </ul>
            </li>
            <!-- <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-book-alt'></i>
                        <span class="link_name">Content</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="#" class="link_name">Content</a></li>
                    <li><a href="">Add new Content</a></li>
                    <li><a href="">Manage Movies</a></li>
                    <li><a href="">Manage Series</a></li>
                    <li><a href="">Manage Podcasts</a></li>
                </ul>
            </li> -->
            <li>
                <a href="{{ route('content') }}">
                    <i class='bx bx-line-chart'></i>
                    <span class="link_name">Content Management</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a href="{{ route('content') }}" class="link_name">Content Management</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="{{ route('faqs') }}">
                        <i class='bx bx-question-mark'></i>
                        <span class="link_name">FAQ Management</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('faqs') }}" class="link_name">FAQ Management</a></li>
                    <li><a href="{{ route('user-questions') }}">User Questions</a></li>
                </ul>
            </li>
            <li>

                <ul class="sub-menu blank">
                </ul>
            </li>
            <li>
                <a href="{{ route('catalogues') }}">
                    <i class='bx bx-book-reader'></i>
                    <span class="link_name">Catalogue Management</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a href="{{ route('catalogues') }}" class="link_name">Catalogue Management</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('subscribed-users') }}">
                    <i class='bx bxs-news'></i>
                    <span class="link_name">Subscriptions</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a href="{{ route('subscribed-users') }}" class="link_name">Subscriptions</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('blogs') }}">
                    <i class='bx bxl-blogger'></i>
                    <span class="link_name">Blogs</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a href="{{ route('blogs') }}" class="link_name">Blogs</a></li>
                </ul>
            </li>
            <li>
                <div class="profile-details">
                    <div class="profile-content">
                        <img src="https://media.istockphoto.com/id/1087123716/photo/log-out-finger-pressing-button.jpg?s=1024x1024&w=is&k=20&c=IU-gA-edJid4Bj-29PsrFa8AS3m8eFo_HL1reJ2VrJA=" alt="Profile Picture">
                    </div>

                    <a href="{{ route('logout') }}"><i class='bx bx-log-out'></i></a>

                </div>
            </li>
        </ul>

    </div>
    <section class="home-section">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent pe-4">
            <div class="home-content">
                <i class='bx bx-menu'></i>
                <span class="text">@yield('title')</span>

            </div>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(auth()->check())

                            <i class="fas fa-user me-2"></i>{{ auth()->user()->username }}!
                            @endif

                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li> <a class="dropdown-item" href="" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div> -->
        </nav>
        <div class="container">
            @yield('content')
        </div>
    </section>

    <script>
        let arrow = document.querySelectorAll('.arrow');

        // console.log(arrow);

        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener('click', (e) => {
                console.log(e);

                let arrowParrent = e.target.parentElement.parentElement;
                console.log(arrowParrent);

                arrowParrent.classList.toggle("showMenu");
            });

        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        sidebarBtn.addEventListener('click', (e) => {
            sidebar.classList.toggle("close");
        })
        // console.log(sidebar);
    </script>
    <!-- POPPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>