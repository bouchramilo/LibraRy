<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exemplaire extends Model
{

    use HasFactory;
    protected $table = "exemplaires";

    protected $fillable = [
        "book_id",
        "code_serial_exemplaire",
        "etat",
        "rayon",
        "etagere",
    ];
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
        // 'book_id' est la clé étrangère dans la table `exemplaires`
    }
}
