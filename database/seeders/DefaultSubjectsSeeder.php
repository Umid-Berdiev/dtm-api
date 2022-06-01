<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultSubjectsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('subjects')->truncate();

    DB::table('subjects')->insert([
      [
        'title_uz' => "Ona tili va Adabiyot",
        'title_ru' => "Родной язык и литература",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'title_uz' => "Matematika",
        'title_ru' => "Математика",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'title_uz' => "O'zbekiston tarixi",
        'title_ru' => "История Узбекистана",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
    ]);
  }
}
