<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    protected $fillable = [
        'user_id',
        'exemplaire_id',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour_effectif',
        'status',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($emprunt) {
            $emprunt->date_retour_prevue = $emprunt->date_emprunt->copy()->addDays(15);
        });
    }

}
