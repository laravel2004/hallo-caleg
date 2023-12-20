<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,
            TPSSeeder::class,
        ]);

        \App\Models\User::create([
            'name' => 'Sahabat Yusuf',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('sahabatyusuf123!'),
            'role' => 0,
        ]);

        // \App\Models\User::factory(20)->create();
        // \App\Models\Pendukung::factory(300)->create();
        // $this->call(TPSSeeder::class);
    }
}
