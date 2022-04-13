<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FileUser extends Model
{
    use HasFactory;

    protected $table = 'file_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_id',
        'user_id',
        'created_id',
        'updated_id'
    ];

    /**
     * Get the user that owns the FolderUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The Permits that belong to the FolderUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Permits(): BelongsToMany
    {
        return $this->belongsToMany(Permit::class, 'file_user_permit', 'file_user_id', 'permit_id')->withPivot(['created_id', 'updated_id']);
    }

    /**
     * Get the File that owns the FileUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function File(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}