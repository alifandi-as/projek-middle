<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand">
            <img src="{{ asset('assets/images/Logo.png') }}" width="32px" height="28px">
            Tugas Projek Middle
        </a>
        <form class="d-flex" role="search">
            {{$slot}}
            <button class="btn btn-white" type="submit">Beranda</button>
            <button class="btn btn-yellow" type="submit">Makanan</button>
            <!-- <a href="/login" class="btn btn-yellow" type="submit">Akun</a> -->
        </form>
    </div>
    </nav>