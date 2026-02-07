<?php

namespace App\Services;

use App\Models\AttendanceRecords;
use Carbon\Carbon;

class AttendanceRecordsService
{
    /**
     * Check if time is late (8:45 AM or later)
     * @param string $dateTime
     * @return bool
     */
    private function isLate($dateTime)
    {
        $time = Carbon::createFromFormat('Y-m-d H:i:s', $dateTime);
        $lateTime = $time->copy()->setTime(8, 45, 0);
        
        return $time->greaterThanOrEqualTo($lateTime);
    }
    
    /**
     * Get all attendance records
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return AttendanceRecords::with('student')->all();
    }
    
    /**
     * Get an attendance record by ID
     * @param int $id
     * @return AttendanceRecords|null
     */
    public function getById($id)
    {
        return AttendanceRecords::with('student')->find($id);
    }
    
    /**
     * Create a new attendance record
     * @param array $data
     * @return AttendanceRecords
     */
    public function create(array $data)
    {
        // Automatically set status to Late if arrival time is 8:45 AM or later
        if ($this->isLate($data['date'])) {
            $data['status'] = 'Late';
        }
        
        return AttendanceRecords::create($data);
    }
    
    /**
     * Update an attendance record
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        $record = AttendanceRecords::find($id);
        
        if (!$record) {
            return false;
        }
        
        // Automatically set status to Late if arrival time is 8:45 AM or later
        if (isset($data['date']) && $this->isLate($data['date'])) {
            $data['status'] = 'Late';
        }
        
        return $record->update($data);
    }
    
    /**
     * Delete an attendance record
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $record = AttendanceRecords::find($id);
        
        if (!$record) {
            return false;
        }
        
        return $record->delete();
    }
    
    /**
     * Save an attendance record
     * @param array $data
     * @return AttendanceRecords
     */
    public function save(array $data)
    {
        // Automatically set status to Late if arrival time is 8:45 AM or later
        if ($this->isLate($data['date'])) {
            $data['status'] = 'Late';
        }
        
        $record = new AttendanceRecords();
        $record->fill($data);
        $record->save();
        
        return $record;
    }
    
    /**
     * Get attendance records by student ID
     * @param int $studentId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByStudentId($studentId)
    {
        return AttendanceRecords::where('student_id', $studentId)->get();
    }
}
