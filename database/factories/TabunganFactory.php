<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tabungan>
 */
class TabunganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'siswa_id' => \App\Models\Siswa::inRandomOrder()->first()->id,
            'tipe' => $this->faker->randomElement(['in', 'out']),
            'jumlah' => $this->faker->numberBetween(10000, 1000000),
            'saldo' => $this->faker->numberBetween(10000, 1000000),
            'keperluan' => $this->faker->sentence(),
        ];
    }


    /**
     * Indicate that the jumlah is jutaan
     */
    public function jutaan(): static
    {
        return $this->state(fn(array $attributes) => [
            'jumlah' => $this->faker->numberBetween(1000000, 10000000),
        ]);
    }

    /**
     * Indicate that the jumlah is puluhan ribu
     */
    public function puluhanRibu(): static
    {
        return $this->state(fn(array $attributes) => [
            'jumlah' => $this->faker->numberBetween(10000, 99999),
        ]);
    }

    /**
     * Indicate that the tabungan is in.
     */
    public function in(): static
    {
        return $this->state(fn(array $attributes) => [
            'tipe' => 'in',
        ]);
    }

    /**
     * Indicate that the tabungan is out.
     */
    public function out(): static
    {
        return $this->state(fn(array $attributes) => [
            'tipe' => 'out',
        ]);
    }
}
