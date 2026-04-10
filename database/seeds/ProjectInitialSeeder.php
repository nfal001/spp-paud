<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectInitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pengaturan
        DB::unprepared("
            INSERT INTO `pengaturan` (`id`, `nama`, `logo`, `created_at`, `updated_at`) VALUES (1, 'Sistem Informasi', 'logo.png', NULL, NULL);
        ");

        // Periode
        Periode::factory()->count(2)->create();
        Periode::factory()->active()->create();

        // Kelas
        Kelas::factory()->count(6)->create();

        // Siswa
        Siswa::factory()->count(50)->create();
    }
}
