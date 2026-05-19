<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model {
    protected $fillable = ['subject_id', 'exam_date', 'start_time', 'end_time', 'max_students', 'status'];

    public function subject() { return $this->belongsTo(Subject::class); }
    public function registrations() { return $this->hasMany(ExamRegistration::class); }

    public function scopeAnnounced($query) { return $query->where('status', 'announced'); }
    public function isCompleted(): bool { return $this->status === 'completed'; }

    public function isFull(): bool {
        $count = $this->registrations_count ?? $this->registrations()->count();
        return $count >= $this->max_students;
    }
}
