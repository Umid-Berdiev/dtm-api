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
    DB::table('languages')->truncate();

    DB::table('languages')->insert([
      [
        'name_uz' => 'O\'zbekcha',
        'name_ru' => 'Узбекский',
        'code' => 'uz'
      ],
      [
        'name_uz' => 'Ruscha',
        'name_ru' => 'Русский',
        'code' => 'ru'
      ]
    ]);
  }
}
