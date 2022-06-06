<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Result;

class Alternative extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','title_id'];
}
