<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Field extends Model {
    protected $fillable = ['name', 'description'];

    public function subjects() { return $this->hasMany(Subject::class); }
    public function courses() { return $this->hasMany(Course::class); }
    public function teacherApplications() { return $this->hasMany(TeacherApplication::class); }
}
