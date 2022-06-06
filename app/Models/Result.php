<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Alternative;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['alternative_id','result'];
}
