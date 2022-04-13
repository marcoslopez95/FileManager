<?php

namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository;
use App\Models\Folder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FolderRepository extends BaseRepository
{
    public function __construct(Folder $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        if ($this->CheckedAdmin()) {
            $folders = Folder::orderBy('name')->get();
            return $folders;
        } else {
            $folders = Auth::user()->Folders;
            $folders_user = collect([]);
            $i = 0;
            foreach ($folders as $folder) {
                $folder->load('Folder');

                $folders_user = $folders_user->concat($folder->only('folder'));
                //$folder->created_at = Carbon::parse($folder->created_at)->format('m-d-Y');
            }
            return $folders_user;
        }
    }


    public function store($data)
    {
        return parent::store($data);
        //
    }

    public function filesByFolder($folder)
    {
    }


    public function update($id, $data)
    {
        return  parent::update($id, $data);
    }

    public function showFolderByUser($id)
    {
        $user = User::find($id);
        $user->load('Folders');
        return $user;
    }
}