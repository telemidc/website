<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TeacherContract extends Model {
    protected $fillable = ['teacher_application_id', 'contract_duration', 'contract_text', 'salary', 'start_date'];

    public function teacher() { return $this->belongsTo(TeacherApplication::class, 'teacher_application_id'); }
}
