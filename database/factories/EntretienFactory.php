<?php

namespace Database\Factories;

use App\Models\Candidature;
use App\Models\Entretien;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntretienFactory extends Factory
{
    protected $model = Entretien::class;

    public function definition(): array
    {
        return [
            'candidature_id' => Candidature::factory(),
            'type' => fake()->randomElement(array_keys(Entretien::TYPES)),
            'date_heure' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'notes' => fake()->optional()->sentence(),
            'resultat' => fake()->randomElement(array_keys(Entretien::RESULTATS)),
        ];
    }
}
