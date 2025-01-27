<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'photo',
        'path_image',
        'isAdmin',
        'setor_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScopes([
            'active' => function (Builder $builder) {
                $builder->where('active', true);
            },
            'created' => function (Builder $builder) {
                $builder->orderBy('created_at');
            },
        ]);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function departament(): BelongsTo
    {
        return $this->belongsTo(Departament::class, 'setor_id');
    }

    public function unidadeUsuario(): HasOne
    {
        return $this->hasOne(UnidadeUsuario::class);
    }

    public function unidade(): HasOneThrough
    {
        return $this->hasOneThrough(Unidade::class, UnidadeUsuario::class, 'user_id', 'id', 'id', 'unidade_id');
    }
}
