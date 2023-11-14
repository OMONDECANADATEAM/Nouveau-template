<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3 d-flex justify-content-between xl-12">
        <nav aria-label="breadcrumb">
            <h2 class="font-weight-bolder mb-0">{{ $page }}</h2>
        </nav>

        <ul class="navbar-nav d-flex  justify-content-start">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center fs-4">
                <a href="javascript:;" class="nav-link text-body p-0 fs-4 " id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner fs-4">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center bold cursor-pointer">
                <div style="width: 32px; height: 32px; overflow: hidden; border-radius: 50%; margin-right: 8px;">
                    <img src="../assets/img/ivana-squares.jpg" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <span style="font-weight: bold;">Konan Japhet</span>

            </li>
          </li>
          
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="material-icons fs-4">settings</span>
                </a>
                <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                    <li class="mb-2">
                        <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1 align-items-center justify-content-between">
                                
                                    <span class="material-icons fs-3">
                                        logout
                                    </span>
                                
                                
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        <span class="font-weight-bold">DECONNEXION</span>
                                    </h6>
                                   
                            
                            </div>
                        </a>
                    </li>
                  
                </ul>
            </li>
        </ul>
    </div>
    </div>
</nav>
