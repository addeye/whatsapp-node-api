<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "server",
        "user",
        "serialized"
    ];

    public function participant()
{
    return $this->hasMany(Participant::class);
}

}
