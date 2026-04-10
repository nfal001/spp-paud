<?php

namespace Database\Factories;

use App\Models\Periode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Periode>
 */
class PeriodeFactory extends Factory
{
    protected $model = Periode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tahunMulai = $this->faker->numberBetween(2023, 2026);
        $tahunSelesai = $tahunMulai + 1;
        $tglMulai = "{$tahunMulai}-07-01";
        $tglSelesai = "{$tahunSelesai}-06-30";

        return [
            'nama' => "{$tahunMulai}-{$tahunSelesai}",
            'tgl_mulai' => $tglMulai,
            'tgl_selesai' => $tglSelesai,
            'is_active' => $this->faker->boolean(30),
        ];
    }

    /**
     * Indicate that the periode is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the periode is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
