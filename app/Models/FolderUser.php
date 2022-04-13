<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FolderUser extends Model
{
    use HasFactory;

    protected $table = 'folder_user';

    protected $fillable = [
        'folder_id',
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
     * Get the folder that owns the FolderUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * The Permits that belong to the FolderUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Permits(): BelongsToMany
    {
        return $this->belongsToMany(Permit::class, 'folder_user_permit', 'folder_user_id', 'permit_id');
    }
}