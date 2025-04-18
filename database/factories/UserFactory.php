<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' =>  bcrypt('password'), // password
            'remember_token' => Str::random(10),
        ];
    }


    public function withRole($roleName = 'admin')
    {
        return $this->afterCreating(function ($user) use ($roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]); // تأكد من وجود الدور
            $user->roles()->attach($role); // ربط الدور بالمستخدم
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
