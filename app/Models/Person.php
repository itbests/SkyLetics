<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';
    public $timestamps = false;

    public function status()
    {
        return $this->belongsTo(Status::class, "status_id", "id");
    }
}
