<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\File;
use PDF;

class MemberController extends Controller
{
    public function index()
    {
        $member = User::with(['village','reveral'])
                    ->whereNotNull('nik')
                    ->whereNotIn('level',[1])
                    ->orderBy('created_at','DESC')->get();
        return view('pages.admin.member.index', compact('member'));
    }

    public function profileMember($id)
    {
        $id_user = decrypt($id);
        $userModel = new User();
        $profile = $userModel->with(['village'])->where('id', $id_user)->first();
        $member  = $userModel->with(['village','reveral'])->where('user_id', $id_user)->whereNotIn('id', [$id_user])->get();
        $total_member = count($member);
        return view('pages.admin.member.profile', compact('profile','member','total_member'));


    }

    public function editMember($id)
    {
        $id = decrypt($id);
        $profile = app('UserModel')->getProfile($id);
        return view('pages.admin.member.edit', compact('profile'));
    }

     public function updateMember(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required'
        ]);

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
                'gender' => $request->gender,
                'place_berth' => $request->place_berth,
                'date_berth' => date('Y-m-d', strtotime($request->date_berth)),
                'blood_group' => $request->blood_group,
                'marital_status' => $request->marital_status,
                'job_id' => $request->job_id,
                'religion' => $request->religion,
                'nik'  => $request->nik,
                'education_id'  => $request->education_id,
                'phone_number' => $request->phone_number,
                'whatsapp' => $request->whatsapp,
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
                'gender' => $request->gender,
                'place_berth' => $request->place_berth,
                'date_berth' => date('Y-m-d', strtotime($request->date_berth)),
                'blood_group' => $request->blood_group,
                'marital_status' => $request->marital_status,
                'job_id' => $request->job_id,
                'religion' => $request->religion,
                'nik'  => $request->nik,
                'education_id'  => $request->education_id,
                'phone_number' => $request->phone_number,
                'whatsapp' => $request->whatsapp,
                'village_id'   => $request->village_id,
                'rt'           => $request->rt,
                'rw'           => $request->rw,
                'address'      => $request->address,
            ]);
        }

        $id = encrypt($id);
        return redirect()->route('admin-profile-member', ['id' => $id]);
    }

    public function downloadCard($id)
    {
        $profile = User::with('village')->where('id', $id)->first();
        $pdf = PDF::LoadView('pages.card', compact('profile'))->setPaper('a4');
        return $pdf->download('e-kta-'.$profile->name.'.pdf');
    }
}
