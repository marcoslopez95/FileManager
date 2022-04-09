<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'folder_id',
        'created_id',
        'updated_id'
    ];

    /**
     * The permits that belong to the File
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permits(): BelongsToMany
    {
        return $this->belongsToMany(Permit::class, 'file_permit', 'file_id', 'permit_id');
    }

    /**
     * Get the folder that owns the File
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
