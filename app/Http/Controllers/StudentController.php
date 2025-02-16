<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    
    public function store(Request $request)
    {
        $data = $request->all();

        // Validation
        $validator = Student::validate($data);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Gestion de l'upload des images
        try {
            if ($request->hasFile('profile_picture')) {
                $data['profile_picture'] = ImageUploadService::uploadImage($request->file('profile_picture'), 'students', 'student');
            }
            if ($request->hasFile('residence_certificate')) {
                $data['residence_certificate'] = ImageUploadService::uploadImage($request->file('residence_certificate'), 'students', 'residence');
            }
            if ($request->hasFile('payement_receipt')) {
                $data['payement_receipt'] = ImageUploadService::uploadImage($request->file('payement_receipt'), 'students', 'receipt');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        // Création de l'étudiant
        $student = new Student();
        $student->fill($data);

        
        if (!empty($data['password'])) {
            $student->password = Hash::make($data['password']);
        }

     
        $student->save();

        return response()->json(['message' => 'Student created successfully', 'student' => $student], 201);
    }

    
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $data = $request->all();


        // Validation
        $validator = Student::validate($data, true);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Gestion de l'upload des nouvelles images (remplace les anciennes si existantes)
        try {
            if ($request->hasFile('profile_picture')) {
                ImageUploadService::deleteImage($student->profile_picture); // Supprimer l'ancienne image
                $data['profile_picture'] = ImageUploadService::uploadImage($request->file('profile_picture'), 'students', 'student');
            }
            if ($request->hasFile('residence_certificate')) {
                ImageUploadService::deleteImage($student->residence_certificate);
                $data['residence_certificate'] = ImageUploadService::uploadImage($request->file('residence_certificate'), 'students', 'residence');
            }
            if ($request->hasFile('payement_receipt')) {
                ImageUploadService::deleteImage($student->payement_receipt);
                $data['payement_receipt'] = ImageUploadService::uploadImage($request->file('payement_receipt'), 'students', 'receipt');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // avoid to update password
        }



        $student->update($data);

        return response()->json(['message' => 'Student updated successfully', 'student' => $student], 200);
    }

    
    public function index()
    {
        $students = Student::paginate(10);
        return response()->json($students, 200);
    }

   
    public function show($id)
    {
        $student = Student::findOrFail($id);

        return response()->json(['student' => $student], 200);
    }

    
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Supprimer les images associées avant la suppression de l'étudiant
        ImageUploadService::deleteImage($student->profile_picture);
        ImageUploadService::deleteImage($student->residence_certificate);
        ImageUploadService::deleteImage($student->payement_receipt);


        $student->delete();

        return response()->json(['message' => 'Student deleted successfully'], 200);
    }
}
