<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnidadeUsuario extends Model
{
    use HasFactory;

    protected $table = 'unidades_usuarios';

    protected $fillable = [
        'unidade_id',
        'user_id'
    ];

    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
