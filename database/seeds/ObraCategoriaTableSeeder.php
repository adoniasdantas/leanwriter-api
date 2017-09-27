<?php

use Illuminate\Database\Seeder;

class ObraCategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 30; $i ++) {
            DB::table('obra_categoria')->insert([
                'obra_id' => random_int(1, 10),
                'categoria_id' => random_int(1, 10),
            ]);
        }
    }
}
