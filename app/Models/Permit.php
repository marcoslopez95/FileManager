<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permit extends Model
{
    use HasFactory;

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
     * The roles that belong to the Permit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'permit_rol', 'permit_id', 'rol_id');
    }

    /**
     * The files that belong to the Permit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'file_permit', 'permit_id', 'file_id');
    }
}