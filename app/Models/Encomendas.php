<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomendas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'valor_pago',
        'produto_id',
        'quantidade',
    ];
}
