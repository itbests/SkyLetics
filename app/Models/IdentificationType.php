<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentificationType extends Model
{
    use HasFactory;

    protected $table = 'identification_type';
    public $timestamps = false;

    public function status()
    {
        return $this->belongsTo(Status::class, "status_id", "id");
    }
}
