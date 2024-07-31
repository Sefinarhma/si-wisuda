<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 300px;">
    <ul class="nav nav-pills flex-column mb-auto mt-5 pt-3">
        {{-- Home ada untuk kedua role --}}
        <li>
            <a
                href="/home"
                class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('home') ? 'active' : '' }}"
            >
                <i data-feather="home" style="width: 1.2em"></i>
                Home
            </a>
        </li>

        {{-- Menu untuk admin --}}
        @if (isset(session('role')['is_admin']))
            <li>
                <a
                    href="/tabel"
                    class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('tabel') ? 'active' : '' }}"
                >
                    <i data-feather="table" style="width: 1.2em"></i>
                    Tabel
                </a>
            </li>
            <li>
                <a
                    href="/rekap"
                    class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('rekap') ? 'active' : '' }}"
                >
                    <i data-feather="archive" style="width: 1.2em"></i>
                    Rekap
                </a>
            </li>
            <li>
                <a
                    href="/jadwal"
                    class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('jadwal') ? 'active' : '' }}"
                >
                    <i data-feather="calendar" style="width: 1.2em"></i>
                    Jadwal Wisuda
                </a>
            </li>
        @endif
        {{-- End menu untuk admin --}}

        {{-- Menu untuk mahasiswa --}}
        @if (isset(session('role')['is_mhs']))
            <li>
                <a
                    href="/pendaftaran"
                    class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('pendaftaran') ? 'active' : '' }}"
                >
                    <i data-feather="file-plus" style="width: 1.2em"></i>
                    Pendaftaran
                </a>
            </li>
            <li>
                <a
                    href="/detail"
                    class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('detail') ? 'active' : '' }}"
                >
                    <i data-feather="file-text" style="width: 1.2em"></i>
                    Detail
                </a>
            </li>
        @endif
        {{-- End menu untuk mahasiswa --}}
    </ul>
    <hr>
    <form action="/logout"">
        @csrf
        <button class="btn btn-dark d-flex gap-1 w-100 align-items-center justify-content-center" type="submit" id="buttonSignout">
            <i data-feather="log-out" style="width: 1.2em"></i>
            <span>
                Logout
            </span>
        </button>
    </form>
</div>
