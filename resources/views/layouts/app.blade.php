<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <title>Document</title>
    <link href="/css/bootstrap-icons.css" rel="stylesheet">
    <link href="/css/templatemo-topic-listing.css" rel="stylesheet">
</head>

<body>
    <main>

        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    <i class="bi-back"></i>
                    <span>Topic</span>
                </a>

                <div class="d-lg-none ms-auto me-4">
                    <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-lg-5 me-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="index.html#section_1">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="index.html#section_2">Categories</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="index.html#section_3">Faculty website</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="index.html#section_4">FAQs</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="index.html#section_5">Contact</a>
                        </li>
                    </ul>

                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{Auth::check() ? 'Account' : 'Login'}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            @if (Auth::check() && Auth::user()->student->user->roles[0]->name === 'student')
                                <a class="dropdown-item " href="/dashboard">
                                    <input type="button" class="form-control" value="Profile">
                                </a>
                                <form action="/dashboard/logout" method="post">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('filament.dashboard.auth.logout') }}">
                                        <input class="form-control" type="submit" value="Logout">
                                    </a>
                                </form>
                            @else
                                <a class="dropdown-item" href="{{ route('filament.dashboard.auth.login') }}">Login</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        {{-- <header class="site-header d-flex flex-column justify-content-center align-items-center">
            <div class="container">
                <div class="row justify-content-center align-items-center">

                    <div class="col-lg-5 col-12 mb-5">
                         

                        <h2 class="text-white">FSAAM Library </h2>

                         
                    </div>

                    <div class="col-lg-5 col-12">
                        <div class="topics-detail-block bg-white shadow-lg">
                            <img src="images/topics/undraw_Remote_design_team_re_urdx.png" class="topics-detail-block-image img-fluid">
                        </div>
                    </div>

                </div>
            </div>
        </header> --}}
    </main>
    @yield('content')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="/js/jquery.sticky.js"></script>
    <script src="/js/click-scroll.js"></script>
    <script src="/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function fire_me(msg){
            Swal.fire({
                title: "Success!",
                text: msg,
                icon: "success"
            });
        }
    </script>

</body>

</html>
