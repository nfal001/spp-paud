<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tingkat = $this->faker->randomElement(['10', '11', '12']);
        $jurusan = $this->faker->randomElement(['TKJ', 'DMM', 'RPL', 'MM', 'ALPHA', 'BETA']);

        return [
            'periode_id' => Periode::inRandomOrder()->value('id'),
            'nama' => "{$tingkat} {$jurusan}",
        ];
    }

    /**
     * Create kelas without a periode.
     */
    public function tanpaPeriode(): static
    {
        return $this->state(fn (array $attributes) => [
            'periode_id' => null,
        ]);
    }
}
