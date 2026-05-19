<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExamRegistration extends Model {
    protected $fillable = ['exam_id', 'student_name', 'country', 'email', 'phone', 'score', 'grade'];

    public function exam() { return $this->belongsTo(Exam::class); }
    public function certificate() { return $this->hasOne(Certificate::class, 'exam_registration_id'); }
}
