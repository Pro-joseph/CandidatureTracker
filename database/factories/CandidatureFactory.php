<?php

namespace Database\Factories;

use App\Models\Candidature;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureFactory extends Factory
{
    protected $model = Candidature::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'entreprise' => fake()->company(),
            'poste' => fake()->jobTitle(),
            'url' => fake()->url(),
            'statut' => fake()->randomElement(array_keys(Candidature::STATUTS)),
            'priorite' => fake()->randomElement(array_keys(Candidature::PRIORITES)),
            'notes' => fake()->optional()->sentence(),
            'date_candidature' => fake()->date(),
        ];
    }

    public function trashed(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => now(),
        ]);
    }
}
