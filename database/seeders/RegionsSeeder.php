<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('regions')->truncate();

    DB::table('regions')->insert([
      [
        'soato' => 1718,
        'name_uz' => "Samarqand viloyati",
        'name_ru' => "Самаркандская область",
        'admincenter_uz' => "Samarqand sh.",
        'admincenter_ru' => "г. Самарканд",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1724,
        'name_uz' => "Sirdaryo viloyati",
        'name_ru' => "Сырдарьинская область",
        'admincenter_uz' => "Guliston sh.",
        'admincenter_ru' => "г. Гулистан",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1727,
        'name_uz' => "Toshkent viloyati",
        'name_ru' => "Ташкентская область",
        'admincenter_uz' => "Nurafshon sh.",
        'admincenter_ru' => "г. Нурафшон",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1730,
        'name_uz' => "Farg'ona viloyati",
        'name_ru' => "Ферганская область",
        'admincenter_uz' => "Farg'ona sh.",
        'admincenter_ru' => "г. Фергана",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1733,
        'name_uz' => "Xorazm viloyati",
        'name_ru' => "Хорезмская область",
        'admincenter_uz' => "Urganch sh.",
        'admincenter_ru' => "г. Ургенч",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1726,
        'name_uz' => "Toshkent shahri",
        'name_ru' => "город Ташкент",
        'admincenter_uz' => "Toshkent shahri",
        'admincenter_ru' => "город Ташкент",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1735,
        'name_uz' => "Qoraqalpog'iston Respublikasi",
        'name_ru' => "Республика Каракалпакстан",
        'admincenter_uz' => "Nukus sh.",
        'admincenter_ru' => "г. Hукус",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1722,
        'name_uz' => "Surxondaryo viloyati",
        'name_ru' => "Сурхандарьинская область",
        'admincenter_uz' => "Termiz sh.",
        'admincenter_ru' => "г. Термез",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1703,
        'name_uz' => "Andijon viloyati",
        'name_ru' => "Андижанская область",
        'admincenter_uz' => "Andijon sh.",
        'admincenter_ru' => "г.Андижан",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1706,
        'name_uz' => "Buxoro viloyati",
        'name_ru' => "Бухарская область",
        'admincenter_uz' => "Buxoro sh.",
        'admincenter_ru' => "г. Бухара",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1708,
        'name_uz' => "Jizzax viloyati",
        'name_ru' => "Джизакская область",
        'admincenter_uz' => "Jizzax sh.",
        'admincenter_ru' => "г. Джизак",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1710,
        'name_uz' => "Qashqadaryo viloyati",
        'name_ru' => "Кашкадарьинская область",
        'admincenter_uz' => "Qarshi sh.",
        'admincenter_ru' => "г. Карши",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1712,
        'name_uz' => "Navoiy viloyati",
        'name_ru' => "Навоийская область",
        'admincenter_uz' => "Navoiy sh.",
        'admincenter_ru' => "г. Навои",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
      [
        'soato' => 1714,
        'name_uz' => "Namangan viloyati",
        'name_ru' => "Наманганская область",
        'admincenter_uz' => "Namangan sh.",
        'admincenter_ru' => "г. Наманган",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
    ]);
  }
}
