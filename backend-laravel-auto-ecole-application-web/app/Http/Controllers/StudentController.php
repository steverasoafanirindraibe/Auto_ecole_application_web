<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function listStudent() {
        return view('student.list');
    }

    public function addNewStudent(Request $request) {
        $request->validate([
            'students_firstname' => 'required',
            'students_lastname' => 'required',
            'students_email' => 'required',
            'students_contact' => 'required',
            'students_password' => 'required'

        ]);

        $student = new Student();
        $student->students_firstname=$request->students_firstname;
        $student->students_lastname=$request->students_lastname;
        $student->students_email=$request->students_email;
        $student->students_contact=$request->students_contact;
        $student->students_password = bcrypt($request->students_password);
        $student->save();

        return response()->json([
            'message' => 'Student saved successfully',
            'student' => $student,
        ], 201);    }
}
