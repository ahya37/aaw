<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        $id      = Auth::user()->id;
        $profile = app('UserModel')->getProfile($id);
        return view('pages.profile.index', compact('profile'));
    }

    public function edit($id)
    {
        $profile = app('UserModel')->getProfile($id);
        return view('pages.profile.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        if ($request->hasFile('photo') || $request->hasFile('ktp')) {
            // delete foto lama
            $path = public_path();
            if ($request->photo != null) {
                File::delete($path.'/storage/'.$user->photo);
            }
            if ($request->ktp != null) {
                File::delete($path.'/storage/'.$user->ktp);
            }

            $photo = $request->photo != null ? $request->file('photo')->store('assets/user/photo','public') : $user->photo;
            $ktp   = $request->ktp   != null ? $request->file('ktp')->store('assets/user/ktp','public') : $user->ktp;

            $user->update([
                'nik'  => $request->nik,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'village_id'   => $request->village_id,
                'rt'           => $request->rt,
                'rw'           => $request->rw,
                'address'      => $request->address,
                'photo'        => $photo,
                'ktp'          => $ktp
            ]);

        }else{
            $user->update([
                'nik'  => $request->nik,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'village_id'   => $request->village_id,
                'rt'           => $request->rt,
                'rw'           => $request->rw,
                'address'      => $request->address,
            ]);
        }

        return redirect()->back();
    }
    
}
