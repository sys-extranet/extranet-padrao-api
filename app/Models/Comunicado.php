<?php

namespace App\Models;

use App\Mail\NovoComunicadoMail;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Mail;

class Comunicado extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'tipo_acesso',
        'departament_id',
        'users_id',
        'titulo',
        'texto'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('createdAtDesc', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function remetente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usuarios():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ComunicadoFile::class, 'comunicado_id');
    }
}
