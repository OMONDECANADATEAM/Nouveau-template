<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl w-200" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3 d-flex justify-content-between xl-12">
        <nav aria-label="breadcrumb">
            <h2 class="font-weight-bolder mb-0">{{ $page }}</h2>
        </nav>

        <ul class="navbar-nav d-flex  justify-content-between w-auto">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center fs-4">
                <a href="javascript:;" class="nav-link text-body p-0 fs-4 " id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner fs-4">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </li>
           @include('partials.user')
          
            
        </ul>
    </div>
    </div>
</nav>
