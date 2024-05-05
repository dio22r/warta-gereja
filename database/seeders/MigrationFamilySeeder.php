<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Family::truncate();
        $oldData = DB::connection('mysql_source')->table('mh_keluarga')
            ->where("mh_gereja_id", 21)
            ->whereNull("deleted_at")
            ->get();

        foreach ($oldData as $data) {
            Family::create([
                "name" => $data->name,
                "description" => $data->desc ?? '',
                "total_member" => $data->id
            ]);
        }
    }
}
