<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peticione extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'descripcion', 'destinatario', 'image', 'categoria_id', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categoria()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function firmas()
    {
        return $this->belongsToMany(User::class, 'peticione_user','peticione_id');
    }
}
