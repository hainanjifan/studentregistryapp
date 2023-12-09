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
        //6. University staff also can import excel/csv files to do bulk operations, such as creating, updating, and deleting students data.

        //Edit via Excel / CSV
        $students = Students::where('email', $row[1])->first();

        //If the student exists, update the data; otherwise, insert new data
        if($students){
            $students->update([
                'name'      => $row[0],
                'address'   => $row[2],
                'course'    => $row[3],
            ]);
        }else{
            return new Students([
                'name'      => $row[0],
                'email'     => $row[1],
                'address'   => $row[2],
                'course'    => $row[3],
            ]);
        }

        //If Row 4 has the word 'delete' it will find the email and delete the record; otherwise, return null
        if(isset($row[4]) && $row[4] === 'delete'){
            Students::where('email', $row[1])->delete();
            return null;
        }

        return $students;

    }
}
