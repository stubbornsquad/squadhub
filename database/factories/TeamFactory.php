<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $socialMediaLinks = json_encode([
            'twitch' => $this->faker->url,
            'youtube' => $this->faker->url,
            'discord' => $this->faker->url,
            'website' => $this->faker->url,
        ]);


        return [
            'name' => $this->faker->unique()->company,
            'tag' => $this->faker->unique()->word,
            'slug' => $this->faker->unique()->slug,
            'logo_url' => $this->faker->imageUrl(),
            'description' => $this->faker->text,
            'region' => $this->faker->country,
            'primary_language' => $this->faker->languageCode,
            'social_media_links' => $socialMediaLinks,
            'recruitment_status' => $this->faker->boolean,
            'founded_in' => $this->faker->dateTimeThisCentury,
        ];
    }
}
