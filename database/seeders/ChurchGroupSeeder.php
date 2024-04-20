<?php

namespace Database\Seeders;

use App\Models\ChurchGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChurchGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChurchGroup::create([
            "name" => "Yehuda Family (Rayon 1)",
            "description" => "",
        ]);

        ChurchGroup::create([
            "name" => "Yoshua Family (Rayon 2)",
            "description" => "",
        ]);

        ChurchGroup::create([
            "name" => "Yusuf Family (Rayon 3)",
            "description" => "",
        ]);
    }
}
