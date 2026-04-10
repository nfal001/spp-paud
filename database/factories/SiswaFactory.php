<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisKelamin = $this->faker->randomElement(['L', 'P']);

        return [
            'kelas_id' => Kelas::inRandomOrder()->value('id'),
            'nama' => $this->faker->name($jenisKelamin === 'L' ? 'male' : 'female'),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-18 years', '-5 years')->format('Y-m-d'),
            'jenis_kelamin' => $jenisKelamin,
            'alamat' => $this->faker->address(),
            'nama_wali' => $this->faker->name(),
            'telp_wali' => $this->faker->phoneNumber(),
            'pekerjaan_wali' => $this->faker->randomElement([
                'PNS', 'Wiraswasta', 'Petani', 'Pedagang', 'Buruh', 'Guru', 'Dokter', 'TNI/Polri', 'Karyawan Swasta',
            ]),
            'is_yatim' => $this->faker->boolean(10),
        ];
    }

    /**
     * Indicate that the siswa is yatim.
     */
    public function yatim(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_yatim' => true,
        ]);
    }

    /**
     * Indicate that the siswa is laki-laki.
     */
    public function lakiLaki(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis_kelamin' => 'L',
            'nama' => $this->faker->name('male'),
        ]);
    }

    /**
     * Indicate that the siswa is perempuan.
     */
    public function perempuan(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis_kelamin' => 'P',
            'nama' => $this->faker->name('female'),
        ]);
    }
}
