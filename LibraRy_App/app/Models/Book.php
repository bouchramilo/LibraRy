<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    use HasFactory;
    protected $table = "books";

    protected $fillable = [
        'title',
        'author',
        'resume',
        'photo',
        'nbr_pages',
        'date_edition',
        'isbn',
        'language',
        'prix_emprunte',
        'prix_vente',
    ];

    // Les relations **************************************************************************************************************
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    public function exemplaires()
    {
        return $this->hasMany(Exemplaire::class, 'book_id');
        // 'book_id' est la clé étrangère dans la table `exemplaires`
    }
}
