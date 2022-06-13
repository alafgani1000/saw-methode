<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Result;

class Alternative extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','title_id'];

    public function result()
    {
        return $this->hasOne(Result::class,'alternative_id');
    }
}
