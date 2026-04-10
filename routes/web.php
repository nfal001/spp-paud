<?php

use App\Livewire\Admin\Keuangan\KeuanganIndex;
use App\Livewire\Admin\Kelas\KelasIndex;
use App\Livewire\Admin\Kelas\KelasTambah;
use App\Livewire\Admin\Kelas\KelasUbah;
use App\Livewire\Admin\Periode\PeriodeIndex;
use App\Livewire\Admin\Periode\PeriodeTambah;
use App\Livewire\Admin\Periode\PeriodeUbah;
use App\Livewire\Admin\Siswa\SiswaIndex;
use App\Livewire\Admin\Siswa\Tambah as TambahSiswa;
use App\Livewire\Admin\Siswa\Ubah as UbahSiswa;
use App\Livewire\Admin\Tabungan\TabunganIndex;
use App\Livewire\Admin\Tagihan\TagihanIndex;
use App\Livewire\Admin\Tagihan\TagihanTambah;
use App\Livewire\Admin\Tagihan\TagihanUbah;
use App\Livewire\Admin\TransaksiSpp;
use App\Livewire\Admin\User\TambahUser;
use App\Livewire\Admin\User\UserEdit;
use App\Livewire\Admin\User\UserIndex;
use App\Livewire\DashboardAdmin;
use App\Livewire\TestPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::prefix('spp')->group(function(){
Auth::routes();

Route::middleware(['auth:web'])->group(callback: function () {
    Route::get('/', 'App\Http\Controllers\HomeController@index')->name('web.index');

    Route::get('buku-panduan', function () {
        return view('panduan.buku');
    })->name('buku.panduan');

    Route::get('pengaturan', 'App\Http\Controllers\HomeController@pengaturan')->name('pengaturan.index');
    Route::get('ubah-pengaturan', 'App\Http\Controllers\HomeController@editPengaturan')->name('pengaturan.edit');
    Route::post('ubah-pengaturan', 'App\Http\Controllers\HomeController@storePengaturan')->name('pengaturan.store');

    Route::get('cetak-laporan-harian', 'App\Http\Controllers\HomeController@v2Cetak')->name('laporan-harian.cetak.v2');
    Route::post('cetak-laporan-harian', 'App\Http\Controllers\HomeController@cetak')->name('laporan-harian.cetak');

    Route::get('export-laporan-harian', 'App\Http\Controllers\HomeController@v2Export')->name('laporan-harian.export.v2');
    Route::post('export-laporan-harian', 'App\Http\Controllers\HomeController@export')->name('laporan-harian.export');

    //Siswa
    Route::get('siswa', 'App\Http\Controllers\SiswaController@index')->name('siswa.index');
    Route::get('tambah-siswa', 'App\Http\Controllers\SiswaController@create')->name('siswa.create');
    Route::post('tambah-siswa', 'App\Http\Controllers\SiswaController@store')->name('siswa.store');
    Route::get('siswa/{siswa}/detail', 'App\Http\Controllers\SiswaController@show')->name('siswa.show');
    Route::get('siswa/{siswa}/ubah', 'App\Http\Controllers\SiswaController@edit')->name('siswa.edit');
    Route::post('siswa/{siswa}/ubah', 'App\Http\Controllers\SiswaController@update')->name('siswa.update');
    Route::post('siswa/{siswa}/hapus', 'App\Http\Controllers\SiswaController@destroy')->name('siswa.destroy');
    Route::get('import-siswa', 'App\Http\Controllers\SiswaController@showFormImport')->name('siswa.showimport');
    Route::post('import-siswa', 'App\Http\Controllers\SiswaController@import')->name('siswa.import');
    Route::get('export-siswa', 'App\Http\Controllers\SiswaController@export')->name('siswa.export');

    //Periode
    Route::get('periode', 'App\Http\Controllers\PeriodeController@index')->name('periode.index');
    Route::get('tambah-periode', 'App\Http\Controllers\PeriodeController@create')->name('periode.create');
    Route::post('tambah-periode', 'App\Http\Controllers\PeriodeController@store')->name('periode.store');
    Route::get('periode/{periode}/ubah', 'App\Http\Controllers\PeriodeController@edit')->name('periode.edit');
    Route::post('periode/{periode}/ubah', 'App\Http\Controllers\PeriodeController@update')->name('periode.update');
    Route::post('periode/{periode}/hapus', 'App\Http\Controllers\PeriodeController@destroy')->name('periode.destroy');

    //Kelas
    Route::get('kelas', 'App\Http\Controllers\KelasController@index')->name('kelas.index');
    Route::get('tambah-kelas', 'App\Http\Controllers\KelasController@create')->name('kelas.create');
    Route::post('tambah-kelas', 'App\Http\Controllers\KelasController@store')->name('kelas.store');
    Route::get('kelas/{kelas}/ubah', 'App\Http\Controllers\KelasController@edit')->name('kelas.edit');
    Route::post('kelas/{kelas}/ubah', 'App\Http\Controllers\KelasController@update')->name('kelas.update');
    Route::post('kelas/{kelas}/hapus', 'App\Http\Controllers\KelasController@destroy')->name('kelas.destroy');

    //Tagihan
    Route::get('tagihan', 'App\Http\Controllers\TagihanController@index')->name('tagihan.index');
    Route::get('tambah-tagihan', 'App\Http\Controllers\TagihanController@create')->name('tagihan.create');
    Route::post('tambah-tagihan', 'App\Http\Controllers\TagihanController@store')->name('tagihan.store');
    Route::get('tagihan/{tagihan}/ubah', 'App\Http\Controllers\TagihanController@edit')->name('tagihan.edit');
    Route::post('tagihan/{tagihan}/ubah', 'App\Http\Controllers\TagihanController@update')->name('tagihan.update');
    Route::post('tagihan/{tagihan}/hapus', 'App\Http\Controllers\TagihanController@destroy')->name('tagihan.destroy');

    //Users
    Route::get('user', 'App\Http\Controllers\UserController@index')->name('user.index');
    Route::get('tambah-user', 'App\Http\Controllers\UserController@create')->name('user.create');
    Route::post('tambah-user', 'App\Http\Controllers\UserController@store')->name('user.store');
    Route::get('user/{user}/ubah', 'App\Http\Controllers\UserController@edit')->name('user.edit');
    Route::post('user/{user}/ubah', 'App\Http\Controllers\UserController@update')->name('user.update');
    Route::post('user/{user}/hapus', 'App\Http\Controllers\UserController@destroy')->name('user.destroy');

    //Menabung
    Route::get('tabungan', 'App\Http\Controllers\TabunganController@index')->name('tabungan.index');
    Route::post('menabung', 'App\Http\Controllers\TabunganController@menabung')->name('tabungan.store');
    Route::get('cetak-tabungan/{id}', 'App\Http\Controllers\TabunganController@transaksiCetak')->name('tabungan.transaksicetak');
    Route::get('export-mutasi', 'App\Http\Controllers\TabunganController@export')->name('tabungan.export');
    Route::get('cetak-tabungan-siswa/{siswa}', 'App\Http\Controllers\TabunganController@cetak')->name('tabungan.cetak');
    Route::get('export-tabungan/{siswa}', 'App\Http\Controllers\TabunganController@siswaexport')->name('tabungan.siswa.export');

    //Keuangan
    Route::get('keuangan', 'App\Http\Controllers\KeuanganController@index')->name('keuangan.index');
    Route::post('keuangan', 'App\Http\Controllers\KeuanganController@store')->name('keuangan.store');
    Route::get('export-keuangan', 'App\Http\Controllers\KeuanganController@export')->name('keuangan.export');

    //Pembayaran SPP
    Route::get('transaksi-spp', 'App\Http\Controllers\TransaksiController@index')->name('spp.index');
    Route::post('print-spp', 'App\Http\Controllers\TransaksiController@transaksiPrint')->name('transaksi.print');
    Route::get('export-spp', 'App\Http\Controllers\TransaksiController@transaksiExport')->name('transaksi.export');
    Route::post('print-spp/{siswa?}', 'App\Http\Controllers\TransaksiController@print')->name('spp.print');
    Route::post('export-spp/{siswa?}', 'App\Http\Controllers\TransaksiController@export')->name('spp.export');

    //Kuitansi
    Route::get('kuitansi', 'App\Http\Controllers\KuitansiController@index')->name('kuitansi.index');
    Route::post('kuitansi', 'App\Http\Controllers\KuitansiController@store')->name('kuitansi.store');
    Route::get('kuitansi/{kuitansi}', 'App\Http\Controllers\KuitansiController@print')->name('kuitansi.print');


    Route::get('/testing', TestPage::class)->name('testing.livewire');

    // Livewire
    Route::get('admin/dashboard', DashboardAdmin::class)->name('web.admin.dashboard');
    Route::get('admin/transaksi-spp', TransaksiSpp::class)->name('web.admin.transaksi-spp');

    Route::get('admin/siswa', SiswaIndex::class)->name(name: 'web.admin.siswa.index');
    Route::get('admin/siswa/tambah', TambahSiswa::class)->name(name: 'web.admin.siswa.tambah');
    Route::get('admin/siswa/{siswa}/ubah', UbahSiswa::class)->name(name: 'web.admin.siswa.edit');

    Route::get('admin/tagihan', TagihanIndex::class)->name(name: 'web.admin.tagihan.index');
    Route::get('admin/tagihan/tambah', TagihanTambah::class)->name(name: 'web.admin.tagihan.tambah');
    Route::get('admin/tagihan/{tagihanId}/ubah', TagihanUbah::class)->name(name: 'web.admin.tagihan.edit');

    // Kelas
    Route::get('admin/kelas', KelasIndex::class)->name(name: 'web.admin.kelas.index');
    Route::get('admin/kelas/tambah', KelasTambah::class)->name(name: 'web.admin.kelas.tambah');
    Route::get('admin/kelas/{kelas}/ubah', KelasUbah::class)->name(name: 'web.admin.kelas.edit');

    // Periode
    Route::get('admin/periode', PeriodeIndex::class)->name(name: 'web.admin.periode.index');
    Route::get('admin/periode/tambah', PeriodeTambah::class)->name(name: 'web.admin.periode.tambah');
    Route::get('admin/periode/{periode}/ubah', PeriodeUbah::class)->name(name: 'web.admin.periode.edit');

    Route::get('admin/user', UserIndex::class)->name(name: 'web.admin.user.index');
    Route::get('admin/user/tambah', TambahUser::class)->name(name: 'web.admin.user.tambah');
    Route::get('admin/user/{user}/ubah', UserEdit::class)->name(name: 'web.admin.user.edit');

    Route::get('admin/keuangan', KeuanganIndex::class)->name(name: 'web.admin.keuangan.index');
    Route::get('admin/tabungan', TabunganIndex::class)->name(name: 'web.admin.tabungan.index');
});
// });




