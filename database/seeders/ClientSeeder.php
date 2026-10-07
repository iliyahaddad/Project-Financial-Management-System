<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'پتروشیمی south', 'status' => 'active'],
            ['name' => 'شرکت صنعتی north', 'status' => 'active'],
            ['name' => 'شرکت آب و برق east', 'status' => 'active'],
            ['name' => 'شرکت توان west', 'status' => 'active'],
            ['name' => 'شرکت فنی center', 'status' => 'active'],
        ];

        foreach ($clients as $client) {
            Client::firstOrCreate(['name' => $client['name']], $client);
        }
    }
}
