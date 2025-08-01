<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            ['name' => 'Blogging', 'slug' => 'blogging'],
            ['name' => 'Content Marketing', 'slug' => 'content-marketing'],
            ['name' => 'SEO', 'slug' => 'seo'],
            ['name' => 'Social Media', 'slug' => 'social-media'],
            ['name' => 'Writing Tips', 'slug' => 'writing-tips'],
            ['name' => 'Copywriting', 'slug' => 'copywriting'],
            ['name' => 'Digital Marketing', 'slug' => 'digital-marketing'],
            ['name' => 'Guest Posting', 'slug' => 'guest-posting'],
            ['name' => 'WordPress', 'slug' => 'wordpress'],
            ['name' => 'Blog Design', 'slug' => 'blog-design'],
            ['name' => 'Affiliate Marketing', 'slug' => 'affiliate-marketing'],
            ['name' => 'Email Marketing', 'slug' => 'email-marketing'],
            ['name' => 'Blogging Tools', 'slug' => 'blogging-tools'],
            ['name' => 'Traffic Growth', 'slug' => 'traffic-growth'],
            ['name' => 'Monetization', 'slug' => 'monetization'],
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name' => $tag['name'],
                'slug' => $tag['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
