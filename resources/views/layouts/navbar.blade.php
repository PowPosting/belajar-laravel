<nav id="nav" class="navbar navbar-expand-lg navbar-container" style="background-color: #FFFFFF;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo dan Toggle Sidebar -->
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-none me-2" id="sidebarToggle">
                <i class="fa-solid fa-bars text-black"></i>
            </button>
            <a href="/" class="navbar-brand">
                <img src="{{ asset('images/logo-oryza.png') }}" alt="Logo" width="100" height="40"
                    class="d-inline-block align-text-top">
            </a>
        </div>

        <!--Search Bar -->
        <form class="d-flex align-items-center" role="search" style="position: relative;">
            <input class="search-control" type="search" placeholder="Masukan No. RM atau Nama Pasien"
                aria-label="Search"
                style="width: 350px; border-radius: 5px; padding-left: 30px; height: 40px; border-color: #ccc;">
            <i class="fa-solid fa-magnifying-glass"
                style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
        </form>

        <!-- Dropdown Menu -->
        <div class="dropdown">
            <button type="button" class="btn btn-toggle dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-user"><span style="font-family: 'roboto';">
                        {{ Auth::user()->username }}
                    </span>
                </i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i> Profile</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>