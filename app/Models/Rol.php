<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rols';
    protected $guarded = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'created_id',
        'updated_id'
    ];

    /**
     * Get all of the users for the Rol
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'rol_id');
    }

    /**
     * The permits that belong to the Rol
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permits(): BelongsToMany
    {
        return $this->belongsToMany(Permit::class, 'permit_rol', 'rol_id', 'permit_id');
    }
}
