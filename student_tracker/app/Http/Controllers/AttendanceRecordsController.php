<?php

namespace App\Http\Controllers;

use App\Services\AttendanceRecordsService;
use Illuminate\Http\Request;

class AttendanceRecordsController extends Controller
{
    protected $attendanceService;
    
    public function __construct(AttendanceRecordsService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    
    /**
     * Get all attendance records
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        try {
            $records = $this->attendanceService->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance records retrieved successfully',
                'data' => $records
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve attendance records',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Create a new attendance record
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|integer|exists:students,id',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'status' => 'required|in:Present,Absent,Late',
                'remarks' => 'nullable|string'
            ]);
            
            $record = $this->attendanceService->create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance record created successfully',
                'data' => $record
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
                'message' => 'Failed to create attendance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update an attendance record
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'integer|exists:students,id',
                'date' => 'date_format:Y-m-d H:i:s',
                'status' => 'in:Present,Absent,Late',
                'remarks' => 'nullable|string'
            ]);
            
            $success = $this->attendanceService->update($id, $validated);
            
            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance record not found'
                ], 404);
            }
            
            $record = $this->attendanceService->getById($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance record updated successfully',
                'data' => $record
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
                'message' => 'Failed to update attendance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete an attendance record
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $success = $this->attendanceService->delete($id);
            
            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance record not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance record deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete attendance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Save an attendance record
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|integer|exists:students,id',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'status' => 'required|in:Present,Absent,Late',
                'remarks' => 'nullable|string'
            ]);
            
            $record = $this->attendanceService->save($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance record saved successfully',
                'data' => $record
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
                'message' => 'Failed to save attendance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get attendance records by student ID
     * @param int $studentId
     * @return \Illuminate\Http\Response
     */
    public function getByStudent($studentId)
    {
        try {
            $records = $this->attendanceService->getByStudentId($studentId);
            
            return response()->json([
                'success' => true,
                'message' => 'Student attendance records retrieved successfully',
                'data' => $records
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve student attendance records',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
