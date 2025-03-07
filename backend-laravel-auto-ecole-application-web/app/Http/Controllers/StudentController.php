<?php

namespace App\Http\Controllers;

use App\Models\student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return response()->json(student::all());
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
            'email' => 'required|email|unique:students',
            'password' => 'required|string'
        ]);
    
        $student = student::create($validated);
        return response()->json($student, 201);
    }
    
    public function show($id)
    {
        return response()->json(student::findOrFail($id));
    }
    
    public function update(Request $request, $id)
    {
        $student = student::findOrFail($id);
        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'adresse' => 'sometimes|string',
            'telephone' => 'sometimes|string',
            'email' => 'sometimes|email|unique:students,email,'.$student->id,
            'password' => 'required|string'
        ]);
    
        $student->update($validated);
        return response()->json($student);
    }
    
    public function destroy($id)
    {
        student::findOrFail($id)->delete();
        return response()->json(null, 204); 
    }
}
