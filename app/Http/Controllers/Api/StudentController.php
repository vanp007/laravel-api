<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Responsable;
use PHPUnit\Framework\MockObject\Builder\Stub;

class StudentController extends Controller
{
    //fetching all students
    public function index()
    {
        $students = Student::all();
        if ($students->count() > 0) {
            return response()->json([
                'status' => 200,
                'students' => $students
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Record Found'
            ], 404);
        }
    }

    //inserting students
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'course' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {

            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if ($student) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Student created successful!!!'
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong!'
                ], 500);
            }
        }
    }


    //fetching student by id
    public function show($id)
    {
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No student found'
            ], 404);
        }
    }

    //updating student
    public function edit(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'course' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {

            $student = Student::find($id);
            if ($student) {
                $student->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Student updated successful!!!'
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found'
                ], 404);
            }
        }
    }


    //deleting student
    public function delete($id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Student deleted successful!!!'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }
    }
}
