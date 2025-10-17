<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    //définit des champs à remplir 
    protected $fillable = [
        'user_id',
        'original_url',
        'code',
        'clicks'        
    ];

    //chaque lien apartient à un utilisateur
    public function user(){
        return $this->belongsTo(User::class);
    }
}
