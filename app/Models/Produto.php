<?php

namespace App\Models;

use Database\Factories\ProdutoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'tipo',
        'foto',
        'preco',
        'quantidade',
        'peso'
    ];

    protected static function newFactory()
    {
        return ProdutoFactory::new();
    }
}
