<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "phone",
        "group_id",
        "is_joined",
        "serialized"
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
