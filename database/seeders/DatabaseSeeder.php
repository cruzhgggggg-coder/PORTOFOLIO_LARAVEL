<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProfileSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user (only if not exists)
        User::firstOrCreate(
            ['email' => 'admin@portofolio.dev'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin123456'),
            ]
        );

        // Seed default profile settings
        $defaults = [
            'name'           => 'Your Name',
            'tagline'        => 'Digital Architect & Designer',
            'bio'            => 'I specialize in crafting immersive digital environments where human intuition meets architectural precision.',
            'location'       => 'Jakarta, Indonesia',
            'email'          => 'hello@example.com',
            'years_exp'      => '3',
            'projects_count' => '20',
            'github_url'     => 'https://github.com',
            'linkedin_url'   => '',
            'twitter_url'    => '',
            'hero_badge'     => 'Digital Architect & Designer',
            'hero_line1'     => 'WEAVING LIGHT INTO',
            'hero_line2'     => 'DIGITAL STRUCTURES',
            'hero_desc'      => 'Creating immersive digital environments where aesthetics meet high-performance engineering. Specializing in futuristic UI/UX and motion systems.',
        ];

        foreach ($defaults as $key => $value) {
            ProfileSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        // Run project seeder
        $this->call(ProjectSeeder::class);

        // Run enhanced portfolio seeder (skills, experiences, testimonials, etc.)
        $this->call(EnhancedPortfolioSeeder::class);
    }
}
