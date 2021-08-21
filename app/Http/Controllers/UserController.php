<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use PDF;
use App\Providers\StrRandom;
use Illuminate\Http\Request;
use App\Providers\QrCodeProvider;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        $id      = Auth::user()->id;
        $profile = app('UserModel')->getProfile($id);
        return view('pages.profile.index', compact('profile'));
    }

    public function indexMember()
    {
        return view('pages.member.index');
    }

    public function createNewMember()
    {
        return view('pages.member.create');
    }

    public function profileMyMember($id)
    {
        $id_user = decrypt($id);
        $userModel = new User();
        $profile = $userModel->with(['village'])->where('id', $id_user)->first();
        $member  = $userModel->with(['village'])->where('user_id', $id_user)->whereNotIn('id', [$id_user])->get();
        $total_member = count($member);
        return view('pages.member.profile', compact('profile','member','total_member'));


    }

    public function createReveral()
    {
        $id_user = Auth::user()->id;
        $user    = User::where('id', $id_user)->first();
        return view('pages.create-reveral', compact('user'));
    }

    public function storeReveral(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $user_id = User::where('code', $request->code)->first();
        if ($user_id == NULL) {
            return redirect()->back()->with(['error' => 'kode Reveral tidak tersedia']);
        }else{
            $user    = User::where('id', $id)->first();
            $user->update(['user_id' => $user_id->id]);
        }

        return redirect()->route('user-create-profile')->with(['success' => 'koder Reveral berhasil disimpan']);
    }

    public function create()
    {
        $id_user = Auth::user()->id;
        $user    = User::where('id', $id_user)->first();
        return view('pages.create-profile', compact('user'));
    }

    public function store(Request $request)
    {
           $this->validate($request, [
               'photo' => 'required|mimes:png,jpg,jpeg',
               'ktp' => 'required|mimes:png,jpg,jpeg',
           ]);
           
           $cek_nik = User::select('nik')->where('nik', $request->nik)->first();
           #cek nik jika sudah terpakai
           if ($cek_nik != null) {
               return redirect()->back()->with(['error' => 'NIK yang anda gunakan telah terdaftar']);
           }else{
              
             //  cek jika reveral tidak tersedia
              $cek_code = User::select('code','id')->where('code', $request->code)->first();
               
              if ($cek_code == null) {
                 return redirect()->back()->with(['error' => 'Kode Reveral yang anda gunakan tidak terdaftar']);
              }else{
                  $photo = $request->file('photo')->store('assets/user/photo','public');
                  $ktp   = $request->file('ktp')->store('assets/user/ktp','public');
       
                  $strRandomProvider = new StrRandom();
                  $string            = $strRandomProvider->generateStrRandom();
       
                  $user = User::create([
                      'user_id' => $cek_code->id,
                      'code' => $string,
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
                      'email' => $request->email,
                      'phone_number' => $request->phone_number,
                      'whatsapp' => $request->whatsapp,
                      'village_id'   => $request->village_id,
                      'rt'           => $request->rt,
                      'rw'           => $request->rw,
                      'address'      => $request->address,
                      'photo'        => $photo,
                      'ktp'          => $ktp
                  ]);
   
                  #generate qrcode
                   $qrCode       = new QrCodeProvider();
                   $qrCodeValue  = $user->code.'-'.$user->name;
                   $qrCodeNameFile= $user->code;
                   $qrCode->create($qrCodeValue, $qrCodeNameFile);

              }
           }

        $id = encrypt($user->id);
        return redirect()->route('member-mymember', ['id' => $id])->with('success','Anggota baru telah dibuat');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $profile = app('UserModel')->getProfile($id);
        return view('pages.profile.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|unique:users'
        ]);
        
        $user = User::where('id', $id)->first();
        $id = encrypt($id);

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

        #jika akunnya, redireck ke dashboard akunnya sendiri
        if ($user->id == Auth::user()->id) {
            return redirect()->route('home')->with('success','Profil telah diperbarui');
        }else{
            #jika anggotanya redireck ke dashoard anggotanya
            return redirect()->route('member-mymember', ['id' => $id]);
        }
    }

    public function updateMyProfile(Request $request, $id)
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

        #jika akunnya, redireck ke dashboard akunnya sendiri
        $id = encrypt($id);
        if ($user->id == Auth::user()->id) {
            return redirect()->route('home')->with('success','Profil telah diperbarui');
        }else{
            #jika anggotanya redireck ke dashoard anggotanya
            return redirect()->route('member-mymember', ['id' => $id]);
        }
    }

    public function memberReportPdf()
    {
        $id_user = Auth::user()->id;
        $name    = Auth::user()->name;
        $title   = "Laporan-Anggota- $name";
        $no      = 1;
        $member  = User::with(['village'])->where('user_id', $id_user)->whereNotIn('id', [$id_user])->orderBy('name','ASC')->get();
        $pdf = PDF::loadView('pages.report.member', compact('member','title','no','name'))->setPaper('a4');
        return $pdf->download($title.'.pdf');
    }

    
}
