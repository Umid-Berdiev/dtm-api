<?php

namespace Database\Seeders;

use App\Models\EducationForm;
use Illuminate\Database\Seeder;

class EducationFormSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    EducationForm::truncate();
    EducationForm::insert([
      [
        'title_uz' => "Kuduzgi",
        'title_ru' => "Дневная",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'title_uz' => "Sirtqi",
        'title_ru' => "Заочная",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'title_uz' => "Kechki",
        'title_ru' => "Вечерняя",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ]
    ]);
  }
}
