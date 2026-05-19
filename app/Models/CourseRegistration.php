<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model {
    protected $fillable = ['course_id', 'student_name', 'country', 'email', 'phone'];

    public function course() { return $this->belongsTo(Course::class); }
    public function certificate() { return $this->hasOne(Certificate::class); }
}
