<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Continent;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Continent::create(['name' => 'Châu Âu', 'slug' => 'chau-au']);
        Continent::create(['name' => 'Bắc Mỹ', 'slug' => 'bac-my']);
        Continent::create(['name' => 'Châu Á', 'slug' => 'chau-a']);
        Continent::create(['name' => 'Châu Úc', 'slug' => 'chau-uc']);
        Continent::create(['name' => 'Mỹ Latinh', 'slug' => 'my-latinh']);
        Continent::create(['name' => 'Châu Phi', 'slug' => 'chau-phi']);

        Setting::create([
            'key' => 'list_terms',
            'value' => '[{"singularName": "Category", "pluralName": "Categories", "taxonomy": "category", "isHierarchy": "true"}, {"singularName": "Tag", "pluralName": "Tags", "taxonomy": "tag", "isHierarchy": "false"}]'
        ]);
    }
}
