<?php

namespace App\Imports;

use App\Models\Direction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HeiDirectionImport implements ToModel, WithHeadingRow
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    return new Direction([
      'higher_educational_institution_id' => $row['higher_educational_institution_id'],
      'title_uz'                          => $row['title_uz'],
      'title_ru'                          => $row['title_ru'],
      'description_uz'                    => $row['description_uz'],
      'description_ru'                    => $row['description_ru'],
    ]);
  }

  public function headingRow(): int
  {
    return 1;
  }
}
