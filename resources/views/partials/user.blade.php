<li class="nav-item dropdown pe-2 d-flex align-items-center bold cursor-pointer">
    <div style="width: 32px; height: 32px; overflow: hidden; border-radius: 50%; margin-right: 8px;">
        <img src="https://cdn-kmijh.nitrocdn.com/gfnqmJxHyBvKDHhsVlbZLcBOwySoLpvA/assets/images/optimized/rev-d533326/omondecanada.com/wp-content/uploads/2023/11/BROU-300PX.webp" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    <span style="font-weight: bold;">{{ auth()->user()->name }} {{auth()->user()->last_name}}</span>
</li>

<li class="nav-item dropdown pe-2 d-flex align-items-center">
    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="material-icons fs-4">settings</span>
    </a>
    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
        <li class="mb-2">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="dropdown-item border-radius-md bg-danger">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="material-icons fs-2">logout</span>
                        <h6 class="text-sm font-weight-normal">
                            <span class="font-weight-bold">DECONNEXION</span>
                        </h6>
                    </div>
                </button>
            </form>
        </li>
    </ul>
</li>
