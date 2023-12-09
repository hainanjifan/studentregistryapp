<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Http\Resources\StudentResource;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //4. The Index API must have pagination.
        // Check if a search query parameter is present
        if ($request->has('query')) {
            $query = $request->input('query');

            //3. Perform a search based on name or email
            $students = Students::where('name', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%")
                ->paginate(10); // Adjust the pagination as needed
        } else {
            // If no search query, return all students
            $students = Students::paginate(10);
        }
        
        // Transform the collection using a resource
        $studentsResource = StudentResource::collection($students);

        // Return a JSON response with the transformed data and an HTTP status code
        return response()->json($studentsResource, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    /*public function create()
    {
        //
    }*/

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $student = Students::create($request->all());
        return response()->json($student, 201); //201 = Created | Resource has been created. Useful for POST requests
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //return $student;
        $student = Students::findOrFail($id);
        return new StudentResource($student);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(string $id)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Students::findOrFail($id);
        $student->update($request->all());
        return response()->json(new StudentResource($student), 200); //200 = Ok | Success (Default)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Students::findOrFail($id);
        $student->delete();
        return response()->json(null, 204); //204 = No Content | Deletion Successful
    }

    //6. Upload Excel Files with the use of StudentsImport
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:10240', // Max file size of 10MB
        ]);

        try {
            $file = $request->file('file');
            $fileName = uniqid('students_import_') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $fileName);
    
            // Use the Excel facade to import data from the file
            Excel::import(new StudentsImport, $path);
    
            return redirect()->route('home')->with('uploadMessage', 'Students data imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('uploadMessage', 'Error importing students data: ' . $e->getMessage());
        }
    }
}