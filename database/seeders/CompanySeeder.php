<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            'X',
            'FAA',
            'SSS',
            'GGG',
            'DDD',
        ];
        foreach ($companies as $company) {
            Company::create(['name' => $company]);
        }
    }
}
