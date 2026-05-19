<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    protected $fillable = ['name', 'field_id', 'description', 'start_date', 'end_date', 'is_visible', 'max_students'];
    protected $casts = ['is_visible' => 'boolean'];

    public function field() { return $this->belongsTo(Field::class); }
    public function teachers() {
        return $this->belongsToMany(TeacherApplication::class, 'course_teachers', 'course_id', 'teacher_application_id');
    }
    public function registrations() { return $this->hasMany(CourseRegistration::class); }

    public function isFull(): bool {
        $count = $this->registrations_count ?? $this->registrations()->count();
        return $count >= $this->max_students;
    }
}
