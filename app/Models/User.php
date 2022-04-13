<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

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
        'last_names',
        'email',
        'password',
        'rol_id'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The roles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'rol_user', 'user_id', 'rol_id');
    }

    /**
     * Get all of the files for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    // public function files(): HasManyThrough
    // {
    //     return $this->hasManyThrough(File::class, FilePermit::class);
    // }

    /**
     * The files that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    // public function files(): BelongsToMany
    // {
    //     return $this->belongsToMany(File::class, 'file_permits', 'user_id', 'file_id');
    // }

    // /**
    //  * The folders that belong to the User
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    //  */
    // public function foldersByUser(): BelongsToMany
    // {
    //     return $this->belongsToMany(Folder::class, 'folder_user', 'user_id', 'folder_id');
    // }

    /**
     * Get all of the Folders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Folders(): HasMany
    {
        return $this->hasMany(FolderUser::class);
    }

    /**
     * Get all of the Files for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Files(): HasMany
    {
        return $this->hasMany(FileUser::class);
    }

    public function scopeIsAdmin()
    {
        $roles = Auth::user()->roles;

        foreach ($roles as $rol) {
            if ($rol->id == 1) {
                return true;
            }
        }
        return false;
    }
}