<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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

    public function scopeFilter($builder, $request)
    {
        $builder
            ->when($request->name, function ($query, $name) {
                return $query->where('name', 'ilike', "%$name%");
            })
            ->when($request->created_id, function ($query, $created) {
                return $query->where('created_id', $created);
            })
            ->when($request->updated_id, function ($query, $updated) {
                return $query->where('updated_id', $updated);
            });
    }

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

    /**
     * Get all of the usuarios for the File
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function usuarios(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, FilePermit::class);
    }
}
