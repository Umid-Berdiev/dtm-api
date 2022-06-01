<?php

namespace Database\Seeders;

use App\Imports\HeiDirectionImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HeiDirectionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('directions')->truncate();

    $file = public_path('/excel_files/otm_direction_list.xlsx');

    if (file_exists($file))
      Excel::import(new HeiDirectionImport, $file); // seed qilish uchun public/excel/ file bo'lishi kerak
    else
      $this->command->error('File not found, path: ' . $file);
  }
}
