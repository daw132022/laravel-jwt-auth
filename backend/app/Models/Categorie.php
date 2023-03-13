<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    public function peticione()
    {
        return $this->hasMany('App\Models\Peticione')->withTimestamps();
    }

}
