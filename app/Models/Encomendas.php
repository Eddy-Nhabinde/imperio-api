<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomendas extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'valorPago',
        'Total',
        'produto_id',
        'quantidade',
    ];
}
