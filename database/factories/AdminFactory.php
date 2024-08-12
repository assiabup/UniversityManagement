<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Jetstream\Features;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
      /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = User::class;

    /**
    * Define the model's default state.
    *
    * @return array<string, mixed>
    */
    public function definition()
    {
        return [
            'name' => "admin",
            'email' => "admin@example.com", // Ajout de la virgule manquante ici
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'role'=> 1,
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
    }

    public function withPersonalTeam(): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name.'\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }










}
