<?php

namespace Database\Seeders;

use App\Imports\HeiImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HeiSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('higher_educational_institutions')->truncate();

    $file = public_path('/excel_files/otm_list.xlsx');

    if (file_exists($file))
      // $this->command->error('File found, path: ' . $file);
      // return 'ok';
      Excel::import(new HeiImport, $file); // seed qilish uchun public/excel/ file bo'lishi kerak
    else
      $this->command->error('File not found, path: ' . $file);
  }
}
