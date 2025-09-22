<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Processamento extends Model
{
    use HasFactory;

    protected $fillable = [
    'arquivo',
    'fundo',
    'sequencia',
    'status',
    'user_id',
    'arquivo_cnab'
    ];

    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
