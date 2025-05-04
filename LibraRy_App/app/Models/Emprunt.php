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
            if ($emprunt->date_emprunt && !$emprunt->date_retour_prevue) {
                $emprunt->date_retour_prevue = now()->addDays(15);
            }
        });
    }

    protected $casts = [
        'date_emprunt' => 'datetime',
        'date_retour_prevue' => 'datetime',
        'date_retour_effectif' => 'datetime',
    ];
    public function exemplaire()
    {
        return $this->belongsTo(Exemplaire::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
