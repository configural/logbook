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
        // $this->call(UsersTableSeeder::class);
        
      DB::table('users')->insert([
      'name' => 'admin',
      'email' => 'admin@logbook.local',
      'password' => bcrypt('477465'),
      'role_id' => 1
    ]);
      
      DB::table('roles')->insert(['name' => 'слушатель']);
      DB::table('roles')->insert(['name' => 'преподаватель']);
      DB::table('roles')->insert(['name' => 'методист']);
      DB::table('roles')->insert(['name' => 'администратор']);
      
      
      
    }
}
