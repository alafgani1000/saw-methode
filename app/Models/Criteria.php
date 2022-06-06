<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'criteries';
    protected $fillable = ['title_id','name','category_id','percent'];

    public function category()
    {
        return $this->belongsTo(Categories::class,'category_id');
    }

    public function crip()
    {
        return $this->hasOne(Crip::class,'criteria_id');
    }


}
