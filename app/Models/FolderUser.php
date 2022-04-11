<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderUser extends Model
{
    use HasFactory;

    protected $table = 'folder_user';

    protected $fillable = [
        'folder_id',
        'permit_id',
        'user_id',
        'created_id',
        'updated_id'
    ];
}
