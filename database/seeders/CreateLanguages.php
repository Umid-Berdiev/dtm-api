<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateLanguages extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // DB::table('languages')->truncate();

    DB::table('languages')->insert(['name' => 'O\'zbekcha', 'code' => 'uz']);
    DB::table('languages')->insert(['name' => 'Ruscha', 'code' => 'ru']);
    DB::table('languages')->insert(['name' => 'Qoraqalpoqcha', 'code' => 'qq']);
  }
}
