<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
final class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $socialMediaLinks = json_encode([
            'twitch' => fake()->url,
            'youtube' => fake()->url,
            'discord' => fake()->url,
            'website' => fake()->url,
        ]);

        return [
            'name' => fake()->unique()->company,
            'tag' => fake()->unique()->word,
            'slug' => fake()->unique()->slug,
            'logo_url' => fake()->imageUrl(),
            'description' => fake()->text,
            'region' => fake()->country,
            'primary_language' => fake()->languageCode,
            'social_media_links' => $socialMediaLinks,
            'recruitment_status' => fake()->boolean,
            'founded_in' => fake()->dateTimeThisCentury,
        ];
    }
}
