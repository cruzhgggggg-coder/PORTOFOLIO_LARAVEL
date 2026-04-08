<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title'       => 'Neural Nexus Dashboard',
                'category'    => 'UI/UX Design',
                'year'        => '2024',
                'description' => 'A real-time data visualization platform for high-frequency algorithmic trading interfaces.',
                'image_url'   => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80',
                'tech_stack'  => ['React', 'D3.js', 'WebSockets', 'Tailwind CSS'],
                'tags'        => ['dashboard', 'data-viz', 'trading'],
                'is_featured' => true,
                'link_repo'   => null,
                'link_demo'   => null,
            ],
            [
                'title'       => 'Aether Motion Framework',
                'category'    => 'Motion Systems',
                'year'        => '2024',
                'description' => 'A high-performance motion system for fluid digital interfaces with 60fps guaranteed.',
                'image_url'   => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
                'tech_stack'  => ['Framer Motion', 'Three.js', 'GSAP'],
                'tags'        => ['animation', 'motion', 'webgl'],
                'is_featured' => true,
                'link_repo'   => null,
                'link_demo'   => null,
            ],
            [
                'title'       => 'Lumina Crystal Identity',
                'category'    => 'Brand Strategy',
                'year'        => '2023',
                'description' => 'Visual identity system based on crystalline aesthetics and light refraction for a luxury brand.',
                'image_url'   => 'https://images.unsplash.com/photo-1634986666676-ec8fd927c23d?w=800&q=80',
                'tech_stack'  => ['Adobe CC', 'Cinema 4D', 'Figma'],
                'tags'        => ['branding', 'identity', 'design'],
                'is_featured' => false,
                'link_repo'   => null,
                'link_demo'   => null,
            ],
            [
                'title'       => 'Prism OS Interface',
                'category'    => 'UI/UX Design',
                'year'        => '2023',
                'description' => 'Operating system interface design focused on depth and transparency with next-gen interactions.',
                'image_url'   => 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=800&q=80',
                'tech_stack'  => ['Figma', 'Prototyping', 'System Design'],
                'tags'        => ['os', 'ui', 'glass'],
                'is_featured' => false,
                'link_repo'   => null,
                'link_demo'   => null,
            ],
        ];

        foreach ($projects as $data) {
            Project::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                $data
            );
        }
    }
}
