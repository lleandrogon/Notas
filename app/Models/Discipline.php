<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $table = 'disciplines';
    protected $fillable = ['name'];

    public function grades() {
        return $this->hasMany(Grade::class);
    }
}
