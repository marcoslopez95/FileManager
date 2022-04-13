<?php

namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository;
use App\Models\FileUser;
use App\Models\FolderUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function AsignarCarpetas($user, $data)
    {
        $user = $this->show($user);
        return $user->folders()->create($data);
    }

    public function AsignarArchivos($user, $data)
    {
        $user = $this->show($user);
        return $user->files()->create($data);
    }

    public function AsignarPermisosArchivos(FileUser $FileUser, $permit)
    {
        // return $FileUser;
        $data[] = DB::table('file_user_permit')->insertGetId([
            'file_user_id' => $FileUser->id,
            'permit_id' => $permit,
            'created_id' => Auth::user()->id,
            'updated_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $data;
    }

    public function AsignarPermisosCarpetas(FolderUser $FolderUser, $permit)
    {
        // return $FileUser;
        $data[] = DB::table('folder_user_permit')->insertGetId([
            'folder_user_id' => $FolderUser->id,
            'permit_id' => $permit,
            'created_id' => Auth::user()->id,
            'updated_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $data;
    }

    public function show($id)
    {
        return $this->model->findorfail($id);
    }

    public function showFolderByUser($id)
    {
        $user = $this->show($id);
        $user->load('Folders');
        return $user;
    }

    public function showFilesByUser($id)
    {
        $user = $this->show($id);
        $user->load('Files');
        return $user;
    }
}