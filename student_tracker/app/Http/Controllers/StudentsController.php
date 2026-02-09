<?php

namespace App\Http\Controllers;

use App\Services\StudentsServices;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    protected $studentService;
    
    public function __construct(StudentsServices $studentService)
    {
        $this->studentService = $studentService;
    }
    
 //get
    public function get()
    {
        try {
            $students = $this->studentService->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Students retrieved successfully',
                'data' => $students
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve students',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
   //create
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_number' => 'required|string|max:50|unique:students',
                'full_name' => 'required|string|max:250',
                'course' => 'required|string|max:250',
                'year_level' => 'required|integer',
                'status' => 'in:ACTIVE,INACTIVE,PENDING',
                'section' => 'required|string|max:250',
                'teacher' => 'required|string|max:250',
                'time_in' => 'nullable|date_format:Y-m-d H:i:s',
                'time_out' => 'nullable|date_format:Y-m-d H:i:s'
            ]);
            
            $student = $this->studentService->create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Student created successfully',
                'data' => $student
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create student',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
//update
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'student_number' => 'string|max:50|unique:students,student_number,' . $id,
                'full_name' => 'string|max:250',
                'course' => 'string|max:250',
                'year_level' => 'integer',
                'status' => 'in:ACTIVE,INACTIVE,PENDING',
                'section' => 'string|max:250',
                'teacher' => 'string|max:250',
                'time_in' => 'nullable|date_format:Y-m-d H:i:s',
                'time_out' => 'nullable|date_format:Y-m-d H:i:s'
            ]);
            
            $success = $this->studentService->update($id, $validated);
            
            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }
            
            $student = $this->studentService->getById($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully',
                'data' => $student
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update student',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
  //delete
    public function delete($id)
    {
        try {
            $success = $this->studentService->delete($id);
            
            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete student',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
 //save
    public function save(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_number' => 'required|string|max:50|unique:students',
                'full_name' => 'required|string|max:250',
                'course' => 'required|string|max:250',
                'year_level' => 'required|integer',
                'status' => 'in:ACTIVE,INACTIVE,PENDING',
                'section' => 'required|string|max:250',
                'teacher' => 'required|string|max:250',
                'time_in' => 'nullable|date_format:Y-m-d H:i:s',
                'time_out' => 'nullable|date_format:Y-m-d H:i:s'
            ]);
            
            $student = $this->studentService->save($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Student saved successfully',
                'data' => $student
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save student',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
