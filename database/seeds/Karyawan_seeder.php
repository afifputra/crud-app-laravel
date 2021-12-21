<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class Karyawan_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('id ID');

        for($i=0; $i<=20; $i++){
            DB::table('karyawan_new')->insert([
                'nama' => $faker -> name(),
                'tmptlahir' => $faker -> city(),
                'tgllahir' => $faker -> date('Y-m-d', 'now'),
                'jabatan' => $faker -> jobTitle(),
                'foto' => $faker -> image('public/img', 100, 100, null, false)
            ]);
        }
    }
}
