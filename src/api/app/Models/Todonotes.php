<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Todonotes extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id", "note", "completed_at", "title"
    ];
    

}
