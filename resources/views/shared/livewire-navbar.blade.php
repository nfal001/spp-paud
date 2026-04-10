<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                    <li class="nav-item">
                        <a href="{{ route('web.admin.dashboard') }}" wire:navigate
                            class="nav-link {{ set_active(['web.admin.dashboard'], 'active') }}">
                            <i class="fe fe-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('web.admin.transaksi-spp') }}" wire:navigate
                            class="nav-link {{ set_active(['web.admin.transaksi-spp'], 'active') }}">
                            <i class="fe fe-repeat"></i> Transaksi SPP
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('web.admin.tabungan.index') }}" wire:navigate
                            class="nav-link {{ set_active(['web.admin.tabungan.*'], 'active') }}">
                            <i class="fe fe-repeat"></i> Tabungan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('web.admin.keuangan.index') }}" wire:navigate
                            class="nav-link {{ set_active(['web.admin.keuangan.*'], 'active') }}">
                            <i class="fe fe-repeat"></i> Keuangan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('web.admin.tagihan.index') }}" wire:navigate
                            class="nav-link {{ set_active(['web.admin.tagihan.*'], 'active') }}">
                            <i class="fe fe-box"></i> Tagihan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('web.admin.siswa.index') }}" wire:navigate
                            class="nav-link {{ set_active(['web.admin.siswa.*'], 'active') }}">
                            <i class="fe fe-users"></i> Siswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('web.admin.kelas.index') }}" wire:navigate
                            class="nav-link {{ set_active(['web.admin.kelas.*'], 'active') }}">
                            <i class="fe fe-box"></i>Kelas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('web.admin.periode.index') }}" wire:navigate
                            class="nav-link {{ set_active(['web.admin.periode.*'], 'active') }}">
                            <i class="fe fe-box"></i> Periode
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('kuitansi.index') }}"
                            class="nav-link {{ set_active(['kuitansi.*'], 'active') }}">
                            <i class="fe fe-folder"></i> Kuitansi
                        </a>
                    </li> --}}
                    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'SuperAdmin')
                        <li class="nav-item">
                            <a href="{{ route('web.admin.user.index') }}" wire:navigate
                                class="nav-link {{ set_active(['web.admin.user.*'], 'active') }}">
                                <i class="fe fe-box"></i> Pengguna
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('buku.panduan') }}" class="nav-link {{ set_active(['buku.*'], 'active') }}">
                            <i class="fe fe-book"></i> Buku Panduan
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
