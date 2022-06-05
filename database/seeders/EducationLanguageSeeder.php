<?php

namespace Database\Seeders;

use App\Models\EducationLanguage;
use Illuminate\Database\Seeder;

class EducationLanguageSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    EducationLanguage::truncate();

    EducationLanguage::insert([
      [
        'name_uz' => 'O\'zbekcha',
        'name_ru' => 'Узбекский',
        'code' => 'uz',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'name_uz' => 'Ruscha',
        'name_ru' => 'Русский',
        'code' => 'ru',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'name_uz' => 'Qoraqalpoqcha',
        'name_ru' => 'Каракалпакский',
        'code' => 'qq',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'name_uz' => 'Inglizcha',
        'name_ru' => 'Английский',
        'code' => 'en',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ]
    ]);
  }
}
