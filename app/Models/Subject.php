<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model {
    protected $fillable = ['field_id', 'name', 'description'];

    public function field() { return $this->belongsTo(Field::class); }
    public function exams() { return $this->hasMany(Exam::class); }
}
