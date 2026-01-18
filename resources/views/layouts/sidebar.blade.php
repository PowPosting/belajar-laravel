<div id="sidebar" class="sidebar vh-100" style="background-color: #FFFFFF;">
    <ul class="nav flex-column p-3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('home') }}">
                <i class="fa-solid fa-home"></i> <span>Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-file"></i> <span>Laporan</span>
            </a>
        </li>

        <li>
            <a class="nav-link dropdown-toggle" href="#" id="pendaftaranDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user"></i> <span>Pendaftaran</span>
            </a>

        </li>

        <li>
            <a class="nav-link" href="{{ route('test') }}">
                <i class="fa-solid fa-user"></i> <span>Test</span>
            </a>
        </li>
    </ul>
</div>