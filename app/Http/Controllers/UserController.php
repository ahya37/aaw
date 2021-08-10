<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;

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

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('assets/user/photo','public');

            $user->update([
                'nik'  => $request->nik,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'village_id'   => $request->village_id,
                'rt'           => $request->rt,
                'rw'           => $request->rw,
                'address'      => $request->address,
                'photo'        => $photo
            ]);

            // delete foto lama
        }elseif($request->hasFile('ktp')){
             $ktp   = $request->file('ktp')->store('assets/user/ktp','public');
             $user->update([
                'nik'  => $request->nik,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'village_id'   => $request->village_id,
                'rt'           => $request->rt,
                'rw'           => $request->rw,
                'address'      => $request->address,
                'ktp'          => $ktp
            ]);

            // delete ktp lama
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
