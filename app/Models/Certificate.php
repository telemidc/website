<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model {
    protected $fillable = ['certificate_number', 'course_registration_id', 'exam_registration_id', 'course_name', 'grade', 'notes', 'issued_at'];
    protected $casts = ['issued_at' => 'date'];

    public function registration() { return $this->belongsTo(CourseRegistration::class, 'course_registration_id'); }
    public function examRegistration() { return $this->belongsTo(ExamRegistration::class, 'exam_registration_id'); }

    public function getStudentName(): string {
        return $this->registration->student_name ?? $this->examRegistration->student_name ?? '-';
    }
    public function getCourseName(): string {
        return $this->course_name ?? $this->registration->course->name ?? '-';
    }

    protected static function booted(): void {
        static::creating(function (Certificate $cert) {
            $cert->certificate_number = 'CRD-' . strtoupper(uniqid());
        });
    }
}
