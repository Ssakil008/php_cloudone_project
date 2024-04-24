<?php

namespace Database\Factories;

use App\Models\CredentialForServer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CredentialForServer>
 */
class CredentialForServerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CredentialForServer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $uniqueEmail = "";
        while ($uniqueEmail === "" || CredentialForServer::where('email', $uniqueEmail)->exists()) {
            $uniqueEmail = $this->faker->unique()->safeEmail . mt_rand(1, 9999);
        }

        return [
            'credential_for' => $this->faker->name,
            'email' => $uniqueEmail,
            'mobile' => $this->generateUniqueBangladeshiMobileNumber(),
            'url' => $this->faker->url,
            'ip_address' => $this->faker->ipv4,
            'username' => $this->faker->userName,
            'password' => $this->faker->password, // Plain password for all records
        ];
    }

    /**
     * Generate a Bangladeshi mobile phone number.
     *
     * @return string
     */
    private function generateUniqueBangladeshiMobileNumber()
    {
        $prefixes = ['017', '018', '019', '015', '016'];
        $prefix = $prefixes[array_rand($prefixes)];

        do {
            $suffix = mt_rand(10000000, 99999999);
            $mobileNumber = $prefix . $suffix;
        } while (CredentialForServer::where('mobile', $mobileNumber)->exists());

        return $mobileNumber;
    }
}
