<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::truncate();
        $oldData = DB::connection('mysql_source')->table('mh_jemaat')
            ->where("mh_gereja_id", 21)
            ->whereNull("deleted_at")
            ->get();

        foreach ($oldData as $data) {
            $family = Family::where("total_member", $data->mh_keluarga_id)
                ->first();

            Member::create([
                "name" => $data->name,
                "gender" => $data->sex == 'L' ? 'M' : 'F',
                "birth_date" => $data->date_birth,
                "birth_place" => $data->place_birth,
                "blood_group" => $data->blood_group,
                "address" => $data->address,
                "telp" => $data->telp,
                "email" => $data->email,
                "marital_status" => $data->marital_status,
                "status" => in_array($data->status, [1, -1]) ? $data->status : 0,
                "family_id" => optional($family)->id ?? null
            ]);
        }
    }
}
