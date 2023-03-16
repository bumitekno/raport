<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->name();
        $slug = str_slug($name, '-');
        return [
            'name' => $name,
            'slug' => $slug,
            'email' => $this->faker->unique()->safeEmail(),
            'gender' => $this->faker->randomElement($array = array('male', 'female')),
            'phone' => $this->faker->e164PhoneNumber(),
            'address' => $this->faker->address(),
            'place_of_birth' => $this->faker->city(),
            'date_of_birth' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'last_login' => $this->faker->dateTime($max = 'now', $timezone = null),
            'last_ip' => $this->faker->ipv4(),
            'status' => 1,
            'password' => 12345,
            'created_at' => now(),
        ];
    }
}
