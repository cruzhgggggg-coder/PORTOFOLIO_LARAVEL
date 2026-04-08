<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Experience;
use App\Models\Testimonial;
use App\Models\SeoSetting;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class EnhancedPortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSkills();
        $this->seedExperiences();
        $this->seedTestimonials();
        $this->seedSeoSettings();
        $this->seedSiteSettings();
    }

    private function seedSkills(): void
    {
        $skills = [
            // Frontend
            ['name' => 'React.js', 'category' => 'frontend', 'proficiency' => 92, 'icon' => '⚛️', 'description' => 'Building interactive UIs with hooks, context, and state management', 'sort_order' => 1],
            ['name' => 'Vue.js', 'category' => 'frontend', 'proficiency' => 88, 'icon' => '💚', 'description' => 'Creating scalable applications with Vuex and Composition API', 'sort_order' => 2],
            ['name' => 'TypeScript', 'category' => 'frontend', 'proficiency' => 85, 'icon' => '🔷', 'description' => 'Type-safe development for better code quality', 'sort_order' => 3],
            ['name' => 'Tailwind CSS', 'category' => 'frontend', 'proficiency' => 95, 'icon' => '🎨', 'description' => 'Rapid UI development with utility-first CSS', 'sort_order' => 4],
            ['name' => 'Three.js', 'category' => 'frontend', 'proficiency' => 75, 'icon' => '🎮', 'description' => '3D graphics and interactive visualizations', 'sort_order' => 5],
            
            // Backend
            ['name' => 'Laravel', 'category' => 'backend', 'proficiency' => 93, 'icon' => '🔥', 'description' => 'Full-stack development with Eloquent, queues, and APIs', 'sort_order' => 10],
            ['name' => 'PHP', 'category' => 'backend', 'proficiency' => 90, 'icon' => '🐘', 'description' => 'Modern PHP 8+ with strong typing and design patterns', 'sort_order' => 11],
            ['name' => 'Node.js', 'category' => 'backend', 'proficiency' => 80, 'icon' => '🟢', 'description' => 'Server-side JavaScript for real-time applications', 'sort_order' => 12],
            ['name' => 'PostgreSQL', 'category' => 'backend', 'proficiency' => 85, 'icon' => '🐘', 'description' => 'Advanced queries, indexing, and database optimization', 'sort_order' => 13],
            ['name' => 'MySQL', 'category' => 'backend', 'proficiency' => 88, 'icon' => '🗄️', 'description' => 'Relational database design and performance tuning', 'sort_order' => 14],
            
            // Tools
            ['name' => 'Docker', 'category' => 'tools', 'proficiency' => 78, 'icon' => '🐳', 'description' => 'Containerization for consistent development environments', 'sort_order' => 20],
            ['name' => 'Git', 'category' => 'tools', 'proficiency' => 92, 'icon' => '📦', 'description' => 'Version control and collaborative development workflows', 'sort_order' => 21],
            ['name' => 'AWS', 'category' => 'tools', 'proficiency' => 72, 'icon' => '☁️', 'description' => 'Cloud infrastructure deployment and management', 'sort_order' => 22],
            ['name' => 'CI/CD', 'category' => 'tools', 'proficiency' => 80, 'icon' => '🔄', 'description' => 'Automated testing and deployment pipelines', 'sort_order' => 23],
            ['name' => 'Figma', 'category' => 'tools', 'proficiency' => 85, 'icon' => '🎨', 'description' => 'UI/UX design and prototyping', 'sort_order' => 24],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['name' => $skill['name']],
                array_merge($skill, ['is_active' => true])
            );
        }
    }

    private function seedExperiences(): void
    {
        $experiences = [
            [
                'type' => 'work',
                'title' => 'Senior Full-Stack Developer',
                'company' => 'Tech Innovations Inc.',
                'location' => 'Jakarta, Indonesia',
                'start_date' => '2024-01-15',
                'is_current' => true,
                'description' => 'Leading development of scalable web applications and mentoring junior developers.',
                'highlights' => [
                    'Architected microservices handling 1M+ requests/day',
                    'Reduced page load time by 60% through optimization',
                    'Led team of 5 developers on client projects',
                ],
                'sort_order' => 1,
            ],
            [
                'type' => 'work',
                'title' => 'Full-Stack Developer',
                'company' => 'Digital Agency XYZ',
                'location' => 'Bandung, Indonesia',
                'start_date' => '2022-03-01',
                'end_date' => '2023-12-31',
                'is_current' => false,
                'description' => 'Developed custom web solutions for diverse client portfolio.',
                'highlights' => [
                    'Delivered 20+ client projects on time',
                    'Implemented CI/CD pipelines reducing deployment time by 70%',
                    'Created reusable component library',
                ],
                'sort_order' => 2,
            ],
            [
                'type' => 'work',
                'title' => 'Junior Web Developer',
                'company' => 'Startup Hub',
                'location' => 'Yogyakarta, Indonesia',
                'start_date' => '2020-06-01',
                'end_date' => '2022-02-28',
                'is_current' => false,
                'description' => 'Built MVPs and iterative products for early-stage startups.',
                'highlights' => [
                    'Launched 3 successful MVPs',
                    'Learned agile development methodologies',
                    'Grew from intern to full-time developer',
                ],
                'sort_order' => 3,
            ],
            [
                'type' => 'education',
                'title' => 'Bachelor of Computer Science',
                'company' => 'University of Indonesia',
                'location' => 'Depok, Indonesia',
                'start_date' => '2016-09-01',
                'end_date' => '2020-05-31',
                'is_current' => false,
                'description' => 'Focused on software engineering and web technologies.',
                'highlights' => [
                    'GPA: 3.85/4.00',
                    'Best Thesis Award for Web Security Research',
                    'Active in programming competition team',
                ],
                'sort_order' => 10,
            ],
            [
                'type' => 'certification',
                'title' => 'AWS Certified Solutions Architect',
                'company' => 'Amazon Web Services',
                'start_date' => '2023-06-15',
                'is_current' => true,
                'description' => 'Professional certification in cloud architecture.',
                'link' => 'https://aws.amazon.com/certification/',
                'sort_order' => 20,
            ],
            [
                'type' => 'certification',
                'title' => 'Laravel Certified Developer',
                'company' => 'Laravel',
                'start_date' => '2022-11-20',
                'is_current' => true,
                'description' => 'Official certification in Laravel development.',
                'link' => 'https://laravel.com/certification',
                'sort_order' => 21,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::firstOrCreate(
                ['title' => $exp['title'], 'company' => $exp['company'] ?? ''],
                array_merge($exp, ['is_active' => true])
            );
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'title' => 'CEO',
                'company' => 'TechStart Inc.',
                'email' => 'sarah@techstart.com',
                'content' => 'Exceptional work! The attention to detail and technical expertise exceeded our expectations. Our platform performance improved by 300% after the rebuild.',
                'rating' => 5,
                'project_name' => 'E-commerce Platform Rebuild',
                'is_featured' => true,
                'is_approved' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Michael Chen',
                'title' => 'Product Manager',
                'company' => 'Digital Solutions Co.',
                'email' => 'michael@digitalsolutions.com',
                'content' => 'A true professional who understands both the technical and business aspects of web development. Delivered our complex project ahead of schedule.',
                'rating' => 5,
                'project_name' => 'SaaS Dashboard Application',
                'is_featured' => true,
                'is_approved' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Emily Rodriguez',
                'title' => 'Marketing Director',
                'company' => 'Brand Agency',
                'email' => 'emily@brandagency.com',
                'content' => 'Creative problem solver with excellent communication skills. The interactive portfolio site they built won us multiple design awards.',
                'rating' => 5,
                'project_name' => 'Award-Winning Portfolio Site',
                'is_featured' => true,
                'is_approved' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'David Park',
                'title' => 'CTO',
                'company' => 'Innovation Labs',
                'email' => 'david@innovationlabs.com',
                'content' => 'Outstanding technical skills and great to work with. Transformed our legacy system into a modern, scalable architecture.',
                'rating' => 4,
                'project_name' => 'Legacy System Modernization',
                'is_featured' => false,
                'is_approved' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::firstOrCreate(
                ['name' => $testimonial['name'], 'company' => $testimonial['company']],
                $testimonial
            );
        }
    }

    private function seedSeoSettings(): void
    {
        $seoSettings = [
            [
                'page_key' => 'home',
                'meta_title' => 'Luminescent Architect - Full-Stack Developer & Digital Designer',
                'meta_description' => 'Creating immersive digital experiences where aesthetics meet high-performance engineering. Specializing in Laravel, React, and modern web technologies.',
                'meta_keywords' => 'full-stack developer, laravel developer, react developer, web designer, digital architect',
                'no_index' => false,
            ],
            [
                'page_key' => 'projects',
                'meta_title' => 'Portfolio - Featured Projects | Luminescent Architect',
                'meta_description' => 'Explore my portfolio of web applications, interactive experiences, and digital solutions built with modern technologies.',
                'meta_keywords' => 'portfolio, web projects, laravel projects, react applications, web development',
                'no_index' => false,
            ],
            [
                'page_key' => 'about',
                'meta_title' => 'About Me - Luminescent Architect',
                'meta_description' => 'Learn about my journey as a developer, my skills, experience, and the passion behind creating exceptional digital experiences.',
                'meta_keywords' => 'about developer, developer background, skills and experience, web developer profile',
                'no_index' => false,
            ],
            [
                'page_key' => 'contact',
                'meta_title' => 'Get In Touch - Luminescent Architect',
                'meta_description' => 'Ready to start your next project? Let\'s collaborate and build something amazing together.',
                'meta_keywords' => 'contact developer, hire developer, web development services, freelance developer',
                'no_index' => false,
            ],
        ];

        foreach ($seoSettings as $seo) {
            SeoSetting::firstOrCreate(['page_key' => $seo['page_key']], $seo);
        }
    }

    private function seedSiteSettings(): void
    {
        $siteSettings = [
            ['key' => 'site_name', 'value' => 'Luminescent Architect', 'type' => 'text'],
            ['key' => 'site_tagline', 'value' => 'Digital Architect & Designer', 'type' => 'text'],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean'],
            ['key' => 'contact_email', 'value' => 'hello@luminescent.dev', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '+62 812 3456 7890', 'type' => 'text'],
            ['key' => 'address', 'value' => 'Jakarta, Indonesia', 'type' => 'text'],
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text'],
            ['key' => 'facebook_pixel_id', 'value' => '', 'type' => 'text'],
            ['key' => 'show_tech_marquee', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'show_features_section', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'projects_per_page', 'value' => '9', 'type' => 'integer'],
            ['key' => 'enable_testimonials', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'enable_analytics', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'brand_color_primary', 'value' => '#00f2ff', 'type' => 'text'],
            ['key' => 'brand_color_secondary', 'value' => '#7000ff', 'type' => 'text'],
        ];

        foreach ($siteSettings as $setting) {
            SiteSetting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
