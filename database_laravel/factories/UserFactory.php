<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
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
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'mobile' => $this->generateBangladeshiMobileNumber(),
            'role' => $this->faker->randomElement(['Admin', 'User']),
            'password' => bcrypt('password'), // Default password for all users
        ];
    }

    /**
     * Generate a Bangladeshi mobile phone number.
     *
     * @return string
     */
    private function generateBangladeshiMobileNumber()
    {
        $prefixes = ['017', '018', '019', '015', '016'];
        $prefix = $prefixes[array_rand($prefixes)];
        $suffix = mt_rand(10000000, 99999999);
        return $prefix . $suffix;
    }
}