<?php

use Illuminate\Database\Seeder;

class ObrasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Obra::class, 30)->create();
    }
}
