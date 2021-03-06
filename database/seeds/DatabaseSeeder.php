<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(ObrasTableSeeder::class);
         $this->call(CapitulosTableSeeder::class);
         $this->call(CategoriasTableSeeder::class);
         $this->call(ObraCategoriaTableSeeder::class);
    }
}
