<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StudentResource::collection(Students::all());
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
        $student = Student::create($request->all());
        return response()->json($student, 201); //201 = Created | Resource has been created. Useful for POST requests
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //return $student;

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
        $student->update($request->all());
        return response()->json($student, 200); //200 = Ok | Success (Default)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student->delete();
        return response()->json(null, 204); //204 = No Content | Deletion Successful
    }
}
