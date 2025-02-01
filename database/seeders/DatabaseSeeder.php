<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Caas::factory(20)->create();

        \App\Models\User::factory()->create([
            'nim' => '1234',
            'password' => '1234',
            'is_admin' => true,
        ]);

        \App\Models\Role::factory()->createMany([
            [
                'name' => 'Fire Opal',
                'description' => "The Phoenix is a symbol of hope, rebirth, and endurance, making it a beloved figure to adventurers. Its fiery presence is a beacon in the darkest parts of the cavern. Also, The Phoenix embodies the power of rebirth and fire, using its radiant flame to protect the heart of the cavern. Its regenerative abilities make it nearly indestructible, and it is deeply loved for its wisdom and strength.",
                'image' => '/assets/Gems Card/Gems (1).webp',
                'quota' => 20,
            ],
            [
                'name' => 'Radiant Quartz',
                'description' => "This towering golem possesses immense strength and the ability to manipulate light, using its Radiant Quartz to illuminate dark places and guide travelers safely through dangerous paths. Known for its steadfast protection, the Luminous Golem is trusted and loved by all. It's a figure of stability, guiding adventurers while providing light in the darkest moments.",
                'image' => '/assets/Gems Card/Gems (6).webp',
                'quota' => 20,
            ],
            [
                'name' => 'Crystal Of The Prism',
                'description' => "The Prismatic Dragon controls all forms of elemental magic through its radiant scales that shimmer like the prism’s light. It can manipulate the elements and maintain balance within the cavern's mystical forces. Revered for its elegance and unmatched power, the Prismatic Dragon is adored for its role in keeping peace and harmony within the Crystal Cavern. It's the ultimate protector and guardian.",
                'image' => '/assets/Gems Card/Gems (7).webp',
                'quota' => 20,
            ],
            [
                'name' => 'Moonstone',
                'description' => "The Glimmering Fairy controls the light of the cavern with its ethereal wings made of moonstone. It can heal and guide travelers, offering advice and protection through difficult challenges. Known for its kindness, wisdom, and helpful nature, the Glimmering Fairy is a favorite among explorers. It's a symbol of gentle power, bringing hope and clarity to those in need",
                'image' => '/assets/Gems Card/Gems (8).webp',
                'quota' => 20,
            ],
            [
                'name' => 'Opal Gem',
                'description' => "This serpent is known for its grace and adaptability, capable of navigating through any terrain. The Opal Gem grants it the ability to shift between dimensions, making it a powerful and elusive protector. The Shimmering Serpent is a symbol of wisdom and transformation. Its enchanting beauty and mysterious nature captivate all who encounter it, making it one of the most beloved creatures in the cavern.",
                'image' => '/assets/Gems Card/Gems (9).webp',
                'quota' => 20,
            ],
        ]);
    }
}
