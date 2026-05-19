<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TeacherApplication extends Model {
    protected $fillable = ['name', 'field_id', 'phone', 'bio', 'email', 'status'];

    public function field() { return $this->belongsTo(Field::class); }
    public function contract() { return $this->hasOne(TeacherContract::class); }
    public function courses() {
        return $this->belongsToMany(Course::class, 'course_teachers', 'teacher_application_id', 'course_id');
    }
}
