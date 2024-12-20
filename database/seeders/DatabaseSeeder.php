<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        // `users` table
        User::factory()->create([ // admin
            'name'     => 'Ahmed Yahya',
            'email'    => 'ahmed.yahya@example-email.com',
            'password' => bcrypt('123456')
        ]);

        User::factory()->create([ // admin
            'name'     => 'Samir Sobhy',
            'email'    => 'samir.sobhy@example-email.com',
            'password' => bcrypt('123456')
        ]);

        User::factory()->create([ // supervisor
            'name'     => 'Shady Fayed',
            'email'    => 'shady.fayed@example-email.com',
            'password' => bcrypt('123456')
        ]);

        User::factory()->create([ // regular user
            'name'     => 'Aya Fawzy',
            'email'    => 'aya.fawzy@example-email.com',
            'password' => bcrypt('123456')
        ]);

        User::factory()->create([ // regular user
            'name'     => 'Hesham Rafla',
            'email'    => 'hesham.rafla@example-email.com',
            'password' => bcrypt('123456')
        ]);




        // `projects` table
        Project::factory()->create([
            'name'        => 'Emirates Heights',
            'description' => 'A residential compound in the North Coast.',
        ]);

        Project::factory()->create([
            'name'        => 'Robots',
            'description' => 'A project to build AI robots.',
        ]);

        Project::factory()->create([
            'name'        => 'Rastra',
            'description' => 'Rastra is a company that produces and sells furniture.',
        ]);
    }
}
