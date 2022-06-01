<?php

namespace App\Imports;

use App\Models\HigherEducationalInstitution;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HeiImport implements ToModel, WithHeadingRow
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    return new HigherEducationalInstitution([
      'title_uz'          => $row['name_uz_lat'],
      'title_ru'          => $row['name_ru'],
      // 'description_uz'    => $row[2],
      // 'description_ru'    => $row[3],
      'region_soato'      => $row['region_id'],
    ]);
  }

  public function headingRow(): int
  {
    return 1;
  }
}
