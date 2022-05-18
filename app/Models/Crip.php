<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crip extends Model
{
    use HasFactory;

    protected $fillable = ['criteria_id','data_crips'];

    public function criteria()
    {
        return $this->hasOne(Criteria::class);
    }
}
