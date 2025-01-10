<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Dots',
            'email' => 'admin@dot.com',
            'website' => 'www.dots.com',
            'contact' => '484847747474',
            'industry' => 'Information Technology'
        ]);
    }
}
