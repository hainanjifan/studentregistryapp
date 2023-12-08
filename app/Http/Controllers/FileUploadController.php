<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadController extends Controller
{
    //6. Import Excel/CSV Files
    public function import(Request $request)
    {
        /*$request->validate([
            'file' => 'required|mimes:xlsx,csv|max:10240', // Adjust file types and size limit
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new StudentsImport, $file);

            // Provide feedback on successful import
            return response()->json(['message' => 'File imported successfully'], 200);
        } catch (\Exception $e) {
            // Handle errors during import
            return response()->json(['error' => 'Error importing file', 'details' => $e->getMessage()], 500);
        }*/
        
        try {
            Excel::import(new StudentsImport, $file);

            // Provide feedback on successful import
            return response()->json(['message' => 'File imported successfully'], 200);
        } catch (\Exception $e) {
            // Handle errors during import
            return response()->json(['error' => 'Error importing file', 'details' => $e->getMessage()], 500);
        }
    }
}
