<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Http\Resources\StudentResource;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //4. The Index API must have pagination.
        $students = Students::paginate(10);
        
        // Transform the collection using a resource
        $studentsResource = StudentResource::collection($students);

        // Return a JSON response with the transformed data and an HTTP status code
        return response()->json($studentsResource, 200);

        //return StudentResource::collection(Students::all());
        //return Student::all();
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

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);
    
        $query = $request->input('query');
    
        $students = Student::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->get();
    
        return StudentResource::collection($students);
    }

    public function import(Request $request)
    {
        $request->validate([
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
        }
    }
}