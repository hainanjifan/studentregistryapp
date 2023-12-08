<?php

namespace App\Imports;

use App\Models\Students;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Students([
            'name'      => $row[0],
            'email'     => $row[1],
            'address'   => $row[2],
            'course'    => $row[3],
        ]);
    }
}
