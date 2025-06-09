<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';
    protected $fillable = ['user_id', 'discipline_id', 'bimonthly', 'monthly_note', 'bimonthly_note', 'average', 'result'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function discipline() {
        return $this->belongsTo(Discipline::class);
    }
}
