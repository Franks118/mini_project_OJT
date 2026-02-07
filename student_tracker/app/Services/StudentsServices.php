<?php

namespace App\Services;

use App\Models\Students;

class StudentsServices
{
    /**
     * Get all students
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return Students::all();
    }
    
    /**
     * Get a student by ID
     * @param int $id
     * @return Students|null
     */
    public function getById($id)
    {
        return Students::find($id);
    }
    
    /**
     * Create a new student
     * @param array $data
     * @return Students
     */
    public function create(array $data)
    {
        return Students::create($data);
    }
    
    /**
     * Update a student
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        $student = Students::find($id);
        
        if (!$student) {
            return false;
        }
        
        return $student->update($data);
    }
    
    /**
     * Delete a student
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $student = Students::find($id);
        
        if (!$student) {
            return false;
        }
        
        return $student->delete();
    }
    
    /**
     * Save a student
     * @param array $data
     * @return Students
     */
    public function save(array $data)
    {
        $student = new Students();
        $student->fill($data);
        $student->save();
        
        return $student;
    }
}
